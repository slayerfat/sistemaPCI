<?php namespace PCI\Listeners\Note;

use PCI\Events\Note\NewNoteCreation;
use PCI\Mamarrachismo\Converter\interfaces\StockTypeConverterInterface;
use PCI\Models\Item;

/**
 * Class GenerateItemMovements
 *
 * @package PCI\Listeners\Note
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class GenerateItemMovements
{

    /**
     * @var \PCI\Mamarrachismo\Converter\StockTypeConverter
     */
    private $converter;

    /**
     * @param StockTypeConverterInterface $converter
     */
    public function __construct(StockTypeConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    /**
     * Handle the event.
     *
     * @param \PCI\Events\Note\NewNoteCreation $event
     */
    public function handle(NewNoteCreation $event)
    {
        // obtener los items del evento
        $items = $event->items;

        foreach ($items as $item) {
            $this->converter->setItem($item);

            $type       = $item->pivot->stock_type_id;
            $quantity   = $item->pivot->quantity;
            $noteAmount = $this->converter->convert($type, $quantity);

            // chequear el stock de cada item
            if ($item->stock < $noteAmount || $noteAmount == 0) {
                // TODO: ignorar item en movimientos
                continue;
            }

            // TODO: items perecederos

            // si esta bien la cantidad, entonces ajustamos el stock
            $this->setStock($noteAmount, $item);
        }
    }

    private function setStock($maximum, Item $item)
    {
        // numero de control del total a extraer de los almacenes
        $remainder = 0;

        // controla si el pedido fue completado
        $complete = false;

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
        while ($remainder < $maximum) {
            foreach ($depots as $depot) {
                $type        = $depot->pivot->stock_type_id;
                $quantity    = $depot->pivot->quantity;
                $depotAmount = $this->converter->convert($type, $quantity);

                if (!$complete) {
                    $remainder += abs($depotAmount - $maximum);

                    // si el remanente es mayor al maximo
                    // entonces completamos el pedido.
                    if ($remainder > $maximum || $remainder == 0) {
                        if ($remainder == 0) {
                            $remainder = $maximum;
                        }

                        $quantity = $remainder;
                        $complete = !$complete;
                    }
                }

                // si el remanente es igual al maximo, entonces el
                // stock se acabo, por lo tanto no nos interesa
                // persistir en la base de datos.
                if ($remainder == $maximum) {
                    continue;
                }

                // se persiste el estado actual del stock
                $depotsWithStock[$depot->id] = [
                    'quantity'      => $quantity,
                    'stock_type_id' => $type,
                ];
            }

            if ($maximum > $remainder) {
                // si el stock no es el adecuado, rechazar nota,
                // actualizar comentarios de nota y
                // enviar correo a encargado de almacen
                // junto al creador de nota
                // TODO
            }
        }

        $this->reattachDepots($item, $depotsWithStock);
    }

    /**
     * @param \PCI\Models\Item $item
     * @param                  $depotsWithStock
     * @return void
     */
    private function reattachDepots(Item $item, $depotsWithStock)
    {
        $item->depots()->sync([]);

        foreach ($depotsWithStock as $id => $details) {
            $item->depots()->attach($id, $details);
        }
    }
}
