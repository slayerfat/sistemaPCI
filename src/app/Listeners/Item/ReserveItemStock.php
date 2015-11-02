<?php namespace PCI\Listeners\Item;

use PCI\Events\Item\AbstractItemMovement;
use PCI\Mamarrachismo\Converter\interfaces\StockTypeConverterInterface;

/**
 * Class ReserveItemStock
 *
 * @package PCI\Listeners\Note
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class ReserveItemStock
{

    /**
     * La implementacion del convertidor para las cantidades.
     *
     * @var \PCI\Mamarrachismo\Converter\StockTypeConverter
     */
    private $converter;

    /**
     * Esta clase necesita el convertidor para generar las cantidades.
     *
     * @param StockTypeConverterInterface $converter
     */
    public function __construct(StockTypeConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    /**
     * Handle the event.
     *
     * @param \PCI\Events\Item\AbstractItemMovement $event
     */
    public function handle(AbstractItemMovement $event)
    {
        foreach ($event->items as $item) {
            $this->converter->setItem($item);
            $amount = $this->converter->convert(
                $item->pivot->stock_type_id,
                $item->pivot->quantity
            );

            // chequear el stock de cada item
            if ($item->stock() < $amount || $amount == 0) {
                // TODO: ignorar item
                continue;
            }

            // Eloquent
            $parent = $event->parent;

            // si el item esta por salir, entonces reservamos ese stock
            if ($event->$parent->isMovementTypeOut()) {
                $item->reserved += $amount;
                $item->save();
            }
        }
    }
}
