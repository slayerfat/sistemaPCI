<?php namespace PCI\Listeners\Note;

use PCI\Events\Note\NewNoteCreation;
use PCI\Mamarrachismo\Converter\interfaces\StockTypeConverterInterface;

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
            // numero de control del total a extraer de los almacenes
            $remainder = 0;

            $this->converter->setItem($item);

            $type       = $item->pivot->stock_type_id;
            $quantity   = $item->pivot->quantity;
            $noteAmount = $this->converter->convert($type, $quantity);

            // chequear el stock de cada item
            if ($item->stock < $noteAmount || $noteAmount == 0) {
                // ignorar item en movimientos
                continue;
            }

            // TODO: items perecederos

            // si el stock es valido, generar movimiento y actualizar
            // existencias en almacen en orden descendente,
            // es decir lugares con poco stock primero.
            /** @var \PCI\Models\Depot $depots */
            $depots = $item->depots()
                ->withPivot('quantity', 'stock_type_id')
                ->orderBy('stock_type_id', 'quantity')
                ->get();

            while ($remainder < $noteAmount) {
                foreach ($depots as $depot) {
                    $type        = $depot->pivot->stock_type_id;
                    $quantity    = $depot->pivot->quantity;
                    $depotAmount = $this->converter->convert($type, $quantity);

                    $remainder += abs($depotAmount - $noteAmount);

                    $depot->items()->detach($item->id);

                    if ($remainder > $noteAmount) {
                        $depot->items()->attach(
                            $item->id,
                            [
                                'quantity'      => $remainder,
                                'stock_type_id' => $item->stock_type_id,
                            ]
                        );

                        break;
                    }
                }
            }

            if ($noteAmount > $remainder) {
                // si el stock no es el adecuado, rechazar nota,
                // actualizar comentarios de nota y
                // enviar correo a encargado de almacen
                // junto al creador de nota
            }
        }
    }
}
