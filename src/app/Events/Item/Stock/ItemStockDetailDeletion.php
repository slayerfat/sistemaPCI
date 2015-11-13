<?php namespace PCI\Events\Item\Stock;

use Illuminate\Queue\SerializesModels;
use PCI\Events\Event;
use PCI\Models\StockDetail;

/**
 * Class ItemStockDetailDeletion
 *
 * @package PCI\Events\Item
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class ItemStockDetailDeletion extends Event
{

    use SerializesModels;

    /**
     * @var \PCI\Models\StockDetail
     */
    public $stockDetail;

    /**
     * Create a new event instance.
     *
     * @param \PCI\Models\StockDetail $stockDetail
     */
    public function __construct(StockDetail $stockDetail)
    {
        $this->stockDetail = $stockDetail;
    }
}
