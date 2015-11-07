<?php namespace PCI\Listeners\Item;

use PCI\Events\Item\AbstractItemMovement;

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
     * Handle the event.
     *
     * @param \PCI\Events\Item\AbstractItemMovement $event
     */
    public function handle(AbstractItemMovement $event)
    {
        foreach ($event->items as $item) {
            $item->reserved -= $item->reserved;
            $item->reserved = $item->reserved < 0 ? 0 : $item->reserved;
            $item->save();
        }
    }
}
