<?php namespace PCI\Listeners\Item\Stock;

use PCI\Events\Item\Stock\ItemStockDetailDeletion;
use PCI\Listeners\Email\AbstractEmailListener;
use PCI\Models\StockDetail;

/**
 * Class DeleteStockDetail
 *
 * @package PCI\Listeners\Item\Stock
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class DeleteStockDetail extends AbstractEmailListener
{

    /**
     * Handle the event.
     * FIXME
     *
     * @param  ItemStockDetailDeletion $event
     * @return void
     */
    public function handle(ItemStockDetailDeletion $event)
    {
        $stockDetail = $event->stockDetail;
        $count       = StockDetail::whereStockId($stockDetail->stock_id)->count();

        if ($count <= 1) {
            $stock = $stockDetail->stock;
            $stockDetail->delete();
            $stock->delete();
        }

        $stockDetail->delete();
    }
}
