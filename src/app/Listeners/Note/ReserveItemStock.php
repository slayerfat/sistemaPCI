<?php namespace PCI\Listeners\Note;

use PCI\Events\Note\NewNoteCreation;
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

            $item->reserved += $amount;
            $item->save();
        }
    }
}
