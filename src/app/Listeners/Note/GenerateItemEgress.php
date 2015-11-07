<?php namespace PCI\Listeners\Note;

use PCI\Events\Note\NewItemEgress;
use PCI\Models\Item;

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
        $movements = [];

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
                    . "el stock es {$stock}. tipos incompatibles.";
                $event->note->save();
                // ignora item en movimientos
                continue;
            }

            // TODO: items perecederos

            // si esta bien la cantidad, entonces ajustamos el stock
            if ($this->setStock($noteAmount, $item)) {
                // aprovechamos y generamos los movimientos respectivos
                $movements[$item->id] = [
                    'quantity'      => $quantity,
                    'stock_type_id' => $type,
                    'due'           => null, // FIXME
                ];

                // actualizamos la cantidad reservada del item
                $item->reserved -= $noteAmount;
                $item->reserved > 0 ?: $item->reserved = 0;
                $item->save();
            }
        }

        $this->setMovement($event->note, $movements);
    }

    /**
     * Guarda el stock de cada item en la base de datos,
     * determinando que sea correcto.
     *
     * @param int|float        $requested
     * @param \PCI\Models\Item $item
     * @return bool
     */
    private function setStock($requested, Item $item)
    {
        // numero de control del total a extraer de los almacenes
        $remaining                 = 0;

        // controla si el pedido fue completado
        $incomplete = true;

        // contiene el inventario que necesita debe persistir
        $depotsWithStock = [];

        // si el stock es valido, generar movimiento y actualizar
        // existencias en almacen en orden descendente,
        // es decir lugares con poco stock primero.
        /** @var \PCI\Models\Depot $depots */
        $depots = $item->depots()
            ->withPivot('quantity', 'stock_type_id')
            ->orderBy('stock_type_id', 'quantity')
            ->get();

        // mientras el remanente sea menor al solicitado
        while ($remaining < $requested) {
            foreach ($depots as $depot) {
                $type     = $depot->pivot->stock_type_id;
                $quantity = floatval($depot->pivot->quantity);
                $stock    = $this->converter->convert($type, $quantity);

                if ($incomplete) {
                    // si el stock es mayor al solicitado, entonces terminamos.
                    if ($stock > $requested) {
                        $remainingStock = $stock - $requested;
                        $remaining = $requested;
                        $incomplete     = false;

                        $this->addWithStock($remainingStock, $type, $depotsWithStock, $depot);

                        continue;
                    }

                    // debemos saber cual es el stock final y el remanente
                    $remainingStock = $this->calculateStock($requested, $remaining, $stock);
                    $remaining += $this->calculateRemaining($remainingStock, $stock, $requested, $remaining);

                    // si hay stock debemos asegurarnos que persistimos correctamente
                    if ($remainingStock > 0) {
                        // si el remanente es mayor o igual a
                        // lo solicitado, entonces terminamos.
                        if ($remaining >= $requested) {
                            $incomplete = false;
                            $this->addWithStock($remainingStock, $type, $depotsWithStock, $depot);
                        }

                        continue;
                    } elseif ($stock == $requested || $remaining >= $requested) {
                        // si el stock es igual a la solicitud, entonces
                        // queda cero stock, por lo tanto no persistimos
                        $remaining = $requested;
                        $incomplete = false;
                        continue;
                    }
                } else {
                    // si se completo la solicitud, solo queda
                    // persistir los datos sobrantes del resto de los almacenes.
                    $this->addWithStock($quantity, $type, $depotsWithStock, $depot);
                }
            }
        }

        // NOTA: se hace de esta forma porque no se pudo conseguir
        // la forma de alterar el stock del item sin
        // modificar los ya existentes, es por
        // eso que debemos iterar todos.
        $this->reattachDepots($item, $depotsWithStock);

        return true;
    }

    /**
     * se persiste el estado actual del stock.
     *
     * @param int|float         $quantity
     * @param int|string        $type
     * @param array             $depotsWithStock
     * @param \PCI\Models\Depot $depot
     */
    private function addWithStock(
        $quantity,
        $type,
        array &$depotsWithStock,
        $depot
    ) {
        if ($quantity > 0) {
            $depotsWithStock[$depot->id] = [
                'quantity'      => $quantity,
                'stock_type_id' => $type,
            ];
        }
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
