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
     * Handle the event.
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
                // TODO: ignorar item en movimientos
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
        $remainder = $remainingStock = 0;

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
        while ($remainder < $requested) {
            foreach ($depots as $depot) {
                $type     = $depot->pivot->stock_type_id;
                $quantity = floatval($depot->pivot->quantity);
                $stock    = $this->converter->convert($type, $quantity);

                if ($incomplete) {
                    // si lo que se pide es igual a lo que hay
                    // en almacen, entonces no persistimos.
                    if ($stock > $requested) {
                        $remainingStock = $stock - $requested;
                        $remainder      = $requested;
                        $incomplete     = false;

                        $this->addWithStock($remainingStock, $type, $depotsWithStock, $depot);

                        continue;
                    }

                    $x = $remainder > 0 ? $remainder : $requested;

                    $remainingStock = $stock - $x < 0 ? 0 : $stock - $x;
                    $remainder += abs($stock - $x) == 0 ? $x : abs($stock - $x);

                    if ($remainingStock > 0) {
                        if ($remainder >= $requested) {
                            $incomplete = false;
                            $this->addWithStock($remainingStock, $type, $depotsWithStock, $depot);
                            continue;
                        }
                    } elseif ($stock == $requested) {
                        $remainder  = $requested;
                        $incomplete = false;
                        continue;
                    } elseif ($remainder >= $requested) {
                        $remainder  = $requested;
                        $incomplete = false;
                        continue;
                    }
                } else {
                    $this->addWithStock($quantity, $type, $depotsWithStock, $depot);
                }
            }
        }

        $this->reattachDepots($item, $depotsWithStock);

        return true;
    }

    /**
     * se persiste el estado actual del stock
     *
     * @param $quantity
     * @param $type
     * @param $depotsWithStock
     * @param $depot
     */
    private function addWithStock($quantity, $type, &$depotsWithStock, $depot)
    {
        if ($quantity > 0) {
            $depotsWithStock[$depot->id] = [
                'quantity'      => $quantity,
                'stock_type_id' => $type,
            ];
        }
    }
}
