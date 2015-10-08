<?php namespace PCI\Mamarrachismo\Converter\interfaces;

use PCI\Models\Item;

interface StockTypeCheckerInterface
{

    /**
     * @param $type
     * @param $amount
     * @param \PCI\Models\Item $item
     * @return \PCI\Models\Item
     */
    public function validate($type, $amount, Item $item = null);

    /**
     * @param $type
     * @param $amount
     * @param \PCI\Models\Item $item
     * @return \PCI\Models\Item
     */
    public function convert($type, $amount, Item $item = null);

    /**
     * @param \PCI\Models\Item $item
     * @return bool
     */
    public function isConvertible(Item $item = null);
}
