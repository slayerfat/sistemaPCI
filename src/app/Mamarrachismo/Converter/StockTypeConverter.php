<?php namespace PCI\Mamarrachismo\Converter;

use PCI\Mamarrachismo\Converter\interfaces\StockTypeConverterInterface;
use PCI\Models\Item;

/**
 * Class StockTypeConverter
 *
 * @package PCI\Mamarrachismo\Converter
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class StockTypeConverter implements StockTypeConverterInterface
{

    /**
     * @var \PCI\Models\Item
     */
    private $item;

    /**
     * Los tipos de item que pueden ser convertidos.
     * FIXME?
     *
     * @var array
     */
    private $convertibleTypes = [
        2 => [3 => ['/', 1000], 4 => ['/', (1000 * 1000)]],
        3 => [2 => ['*', 1000], 4 => ['/', 1000]],
        4 => [2 => ['*', (1000 * 1000)], 3 => ['/', 1000]],
    ];

    /**
     * @param \PCI\Models\Item $item
     */
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * @param                  $type
     * @param                  $amount
     * @param \PCI\Models\Item $item
     * @return \PCI\Models\Item
     */
    public function validate($type, $amount, Item $item = null)
    {
        // TODO: Implement validate() method.
    }

    /**
     * @param                  $type
     * @param                  $amount
     * @param \PCI\Models\Item $item
     * @return \PCI\Models\Item
     */
    public function convert($type, $amount, Item $item = null)
    {
        // TODO: Implement convert() method.
    }

    /**
     * @param \PCI\Models\Item $item
     * @return bool
     */
    public function isConvertible(Item $item = null)
    {
        $item = $item ? $item : $this->item;

        return array_key_exists($item->stock_type_id, $this->convertibleTypes);
    }
}
