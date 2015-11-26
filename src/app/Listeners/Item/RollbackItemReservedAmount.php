<?php namespace PCI\Listeners\Item;

use PCI\Events\Item\AbstractItemMovement;
use PCI\Mamarrachismo\Converter\interfaces\StockTypeConverterInterface;

/**
 * Class RollbackItemReservedAmount
 *
 * @package PCI\Listeners\Note
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class RollbackItemReservedAmount
{

    /**
     * La implementacion del convertidor para las cantidades.
     *
     * @var \PCI\Mamarrachismo\Converter\StockTypeConverter
     */
    protected $converter;

    /**
     * @param \PCI\Mamarrachismo\Converter\interfaces\StockTypeConverterInterface $converter
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
            $type     = $item->pivot->stock_type_id;
            $quantity = floatval($item->pivot->quantity);
            $amount   = $this->converter->convert($type, $quantity);

            $item->reserved -= $amount;
            $item->reserved > 0 ?: $item->reserved = 0;
            $item->save();
        }
    }
}
