<?php namespace PCI\Events\Item\Stock;

use Illuminate\Queue\SerializesModels;
use PCI\Events\Event;
use PCI\Models\StockDetail;

/**
 * Class ItemStockDetailChange
 *
 * @package PCI\Events\Item
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class ItemStockDetailChange extends Event
{

    use SerializesModels;

    /**
     * @var \PCI\Models\StockDetail
     */
    public $stockDetail;

    /**
     * @var float|int
     */
    public $amount;

    /**
     * Create a new event instance.
     *
     * @param \PCI\Models\StockDetail $stockDetail
     * @param int|float               $amount
     */
    public function __construct(StockDetail $stockDetail, $amount)
    {
        $this->stockDetail = $stockDetail;
        $this->amount      = $amount;
    }
}
