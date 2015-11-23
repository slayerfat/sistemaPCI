<?php namespace PCI\Listeners\Note;

use Event;
use LogicException;
use PCI\Events\Item\Stock\ItemStockDetailChange;
use PCI\Events\Item\Stock\ItemStockDetailDeletion;
use PCI\Events\Note\NewItemEgress;
use PCI\Models\Item;
use PCI\Models\ItemMovement;
use PCI\Models\StockDetail;

/**
 * Class GenerateItemEgress
 *
 * @package PCI\Listeners\Note
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class GenerateItemEgress extends AbstractItemMovement
{

    /**
     * Manipula al evento.
     *
     * @param \PCI\Events\Note\NewItemEgress $event
     */
    public function handle(NewItemEgress $event)
    {
        // controla si se debe persistir o no el movimiento
        $persist = false;

        // ajustamos el tipo de movimiento del mismo, al tipo de la nota
        $this->movement->movement_type_id = $event->note->type->movement_type_id;

        foreach ($event->items as $item) {
            $this->converter->setItem($item);
            $type       = $item->pivot->stock_type_id;
            $quantity   = floatval($item->pivot->quantity);
            $noteAmount = $this->converter->convert($type, $quantity);
            $stock      = $item->stock();

            // chequear el stock de cada item
            if ($stock < $noteAmount || $noteAmount == 0) {
                $event->note->comments .= sizeof($event->note->comments) <= 1 ? "" : "\r\n";
                $event->note->comments .= "Item {$item->id}, posee cantidad de "
                    . "{$quantity} pero la conversion es {$noteAmount}, "
                    . "el stock es {$stock}. "
                    . "tipos incompatibles. [$type:$item->item_type_id]";
                $event->note->save();
                // ignora item en movimientos
                continue;
            }

            // ajustamos el stock
            $this->setStock($noteAmount, $item);

            // actualizamos la cantidad reservada del item
            $item->reserved -= $noteAmount;
            $item->reserved > 0 ?: $item->reserved = 0;
            $persist = $item->save();

            // creamos objeto que representa nuevo movimiento
            $itemMvt                = new ItemMovement;
            $itemMvt->item_id       = $item->id;
            $itemMvt->quantity      = $quantity;
            $itemMvt->stock_type_id = $type;
            $itemMvt->due           = null;

            $this->itemMovements->push($itemMvt);
        }

        // debemos chequear si debemos o no persistir
        if ($persist) {
            $event->note->movements()->save($this->movement);
            foreach ($this->itemMovements as $itemMovement) {
                $this->movement->itemMovements()->save($itemMovement);
            }

            return;
        }

        throw new LogicException('No se persistieron datos en egreso de item');
    }

    /**
     * Guarda el stock de cada item en la base de datos,
     * determinando que sea correcto.
     *
     * @param int|float        $requested
     * @param \PCI\Models\Item $item
     * @return void
     */
    private function setStock($requested, Item $item)
    {
        // numero de control del total a extraer de los almacenes
        $remaining = 0;

        // el stock del item ordenados por fecha
        $collection = $this->sortStock($item);

        // si el stock es valido, generar movimiento y actualizar
        // existencias en almacen en orden descendente,
        // es decir lugares con poco stock primero.
        foreach ($collection as $detailModel) {
            /** @var \PCI\Models\StockDetail $detailModel */
            $type     = $detailModel->stock->stock_type_id;
            $quantity = floatval($detailModel->quantity);
            $stock    = $this->converter->convert($type, $quantity);

            // si el stock es mayor al solicitado, entonces terminamos.
            if ($stock > $requested) {
                if ($remaining == 0) {
                    $remainingStock = $stock - $requested;
                    $this->changeStock($remainingStock, $detailModel);

                    return;
                }

                $remainingStock = $stock - $remaining;
                $this->changeStock($remainingStock, $detailModel);

                return;
            }

            // debemos saber cual es el stock final y el remanente
            $remainingStock = $this->calculateStock($requested, $remaining, $stock);
            $remaining += $this->calculateRemaining($remainingStock, $stock, $requested, $remaining);

            // si hay stock debemos asegurarnos que persistimos correctamente
            if ($remainingStock > 0) {
                // si el remanente es mayor o igual a
                // lo solicitado, entonces terminamos.
                if ($remaining >= $requested) {
                    $this->changeStock($remainingStock, $detailModel);

                    return;
                }
            } elseif ($stock == $requested || $remaining >= $requested) {
                // si el stock es igual a la solicitud, entonces
                // queda cero stock, eliminamos el modelo
                Event::fire(new ItemStockDetailDeletion($detailModel));

                return;
            }

            // aqui implica que el modelo hay que eliminarlo pero
            // la solicitud no ha sido completada, por lo
            // tanto debemos continuar iterando.
            Event::fire(new ItemStockDetailDeletion($detailModel));
        }

        // para cubrirnos las espaldas.
        throw new LogicException('Egreso de item no pudo ser procesado, item no tiene stock');
    }

    /**
     * Genera una coleccion ordenada por la fecha de vencimiento.
     *
     * @param \PCI\Models\Item $item
     * @return \Illuminate\Support\Collection
     */
    private function sortStock(Item $item)
    {
        // eager-load de las entidades
        $item->load('stocks', 'stocks.details');

        $withoutDate = [];
        $withDates   = collect();

        // debemos buscar los modelos y hacer un collection para
        // ordenar las existencias por fecha de vencimiento.
        foreach ($item->stocks as $stock) {
            foreach ($stock->details as $details) {
                if (is_null($details->due)) {
                    $withoutDate[] = $details;

                    continue;
                }

                $withDates->push($details);
            }
        }

        // generamos una nueva coleccion ordenada
        $collection = $withDates->sortBy('due');

        if (count($withoutDate)) {
            foreach ($withoutDate as $details) {
                $collection->push($details);
            }
        }

        // reseteamos los keys de la coleccion
        $collection->values()->all();

        return $collection;
    }

    /**
     * Actualiza el modelo para ajustar la cantidad existente en almacen.
     *
     * @param int|float   $remainingStock
     * @param StockDetail $stockDetail
     */
    private function changeStock($remainingStock, StockDetail $stockDetail)
    {
        if ($remainingStock <= 0) {
            throw new LogicException('El stock remanente debe ser mayor a cero.');
        }

        Event::fire(new ItemStockDetailChange($stockDetail, $remainingStock));
    }

    /**
     * Chequea y genera el remanente adecuado y el stock final.
     *
     * @param int|float $requested
     * @param int|float $remaining
     * @param int|float $stock
     * @return int|float el stock final
     */
    private function calculateStock(
        $requested,
        $remaining,
        $stock
    ) {
        $operand = $this->findOperand($requested, $remaining);

        // el stock puede ser menor a cero, por lo tanto
        // debemos asegurar que sea al menos cero o mas.
        return $stock - $operand < 0 ? 0 : $stock - $operand;
    }

    /**
     * Busca el operando correcto para determinar el remanente y el stock.
     *
     * @param int|float $requested
     * @param int|float $remaining
     * @return int|float
     */
    private function findOperand($requested, $remaining)
    {
        // debemos asegurarnos de cual sera el operando
        // correcto, porque remanente empieza en cero.
        return $remaining > 0 ? $requested - $remaining : $requested;
    }

    /**
     * Busca cual es el remanente de la iteracion actual en setStock.
     *
     * @param int|float $remainingStock
     * @param int|float $stock
     * @param int|float $requested
     * @param int|float $remaining
     * @return float|int|number
     */
    private function calculateRemaining(
        $remainingStock,
        $stock,
        $requested,
        $remaining
    ) {
        // si el stock es cero, entonces se extrajo lo que
        // habia, por lo tanto se devuelve el stock inicial.
        if ($remainingStock === 0) {
            return $stock;
        }

        $operand = $this->findOperand($requested, $remaining);

        // si el stock menos el operando es igual a cero,
        // entonces son iguales, asi que devolvemos
        // al operando. (o stock, es lo mismo)
        if (abs($stock - $operand) == 0) {
            return $operand;
        }

        // de lo contrario devolvemos lo que hay menos lo que se pide.
        return abs($stock - $operand);
    }
}
