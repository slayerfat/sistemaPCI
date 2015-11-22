<?php namespace PCI\Listeners\Item\Stock;

use PCI\Events\Item\Stock\ItemStockDetailChange;
use PCI\Listeners\Email\AbstractEmailListener;
use PCI\Models\StockDetail;

/**
 * Class ChangeStockDetail
 *
 * @package PCI\Listeners
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class ChangeStockDetail extends AbstractEmailListener
{

    /**
     * Handle the event.
     *
     * @param  ItemStockDetailChange $event
     * @return void
     */
    public function handle(ItemStockDetailChange $event)
    {
        $stockDetails = $event->stockDetail;
        $item         = $stockDetails->stock->item;
        $minimum      = $item->minimum;
        $itemStock    = $item->stock();
        $quantity     = $event->amount;

        if ($quantity > $minimum) {
            $this->update($stockDetails, $quantity);

            return;
        }

        // FIXME
        $this->update($stockDetails, $quantity);
    }

    /**
     * Actualiza el modelo.
     *
     * @param \PCI\Models\StockDetail $stockDetails
     * @param                         $amount
     * @return \PCI\Models\StockDetail
     */
    private function update(StockDetail $stockDetails, $amount)
    {
        $stockDetails->quantity = $amount;
        $stockDetails->save();

        return $stockDetails;
    }

    protected function makeEmails()
    {
        // TODO: Implement makeEmails() method.
    }
}
