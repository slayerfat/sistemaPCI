<?php namespace Tests\PCI\Mamarrachismo\Converter;

use Mockery;
use PCI\Mamarrachismo\Converter\StockTypeConverter;
use PCI\Models\Item;
use Tests\AbstractTestCase;

/**
 * Class StockTypeConverterTest
 *
 * @package Tests\PCI\Mamarrachismo\Converter
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class StockTypeConverterTest extends AbstractTestCase
{

    /**
     * @var \PCI\Mamarrachismo\Converter\StockTypeConverter
     */
    public $converter;

    public function setUp()
    {
        parent::setUp();

        $item = Mockery::mock(Item::class)->makePartial();

        $item->stock_type_id = 3;

        $this->converter = new StockTypeConverter($item);
    }

    /**
     * @dataProvider validateDataProvider
     * @param $itemStockId
     * @param $type
     * @param $expecting
     */
    public function testValidateShouldReturnTrue(
        $itemStockId,
        $type,
        $expecting
    ) {
        /** @var Item $item */
        $item = Mockery::mock(Item::class)->makePartial();

        $item->stock_type_id = $itemStockId;
        $this->converter->setItem($item);

        $this->assertEquals($expecting, $this->converter->validate($type));
    }

    /**
     * @dataProvider convertDataProvider
     * @param $itemStockId
     * @param $type
     * @param $amount
     * @param $result
     */
    public function testConvertShouldReturnValidAmount(
        $itemStockId,
        $type,
        $amount,
        $result
    ) {
        /** @var Item $item */
        $item = Mockery::mock(Item::class)->makePartial();

        $item->stock_type_id = $itemStockId;
        $this->converter->setItem($item);

        $this->assertEquals(
            $result,
            $this->converter->convert($type, $amount)
        );
    }

    public function testGetItemShouldReturnInstanceOfModel()
    {
        $this->assertInstanceOf(Item::class, $this->converter->getItem());
    }

    public function validateDataProvider()
    {
        return [
            'set_1'  => [1, 1, true, 1, 1],
            'set_2'  => [1, 2, false, 1, 0],
            'set_3'  => [1, 3, false, 1, 0],
            'set_4'  => [1, 4, false, 1, 0],
            'set_5'  => [1, 5, false, 1, 0],
            'set_6'  => [2, 1, false, 1, 0],
            'set_7'  => [2, 2, true, 1, 1],
            'set_8'  => [2, 3, true, 1, 1000],
            'set_9'  => [2, 4, true, 1, 1000000],
            'set_10' => [2, 5, false, 1, 0],
            'set_11' => [3, 1, false, 1, 0],
            'set_12' => [3, 2, true, 1, 1000],
            'set_13' => [3, 3, true, 1, 1000000],
            'set_14' => [3, 4, true, 1, 1],
            'set_15' => [3, 5, false, 1, 0],
            'set_16' => [4, 1, false, 1, 0],
            'set_17' => [4, 2, true, 1, 1],
            'set_18' => [4, 3, true, 1, 1],
            'set_19' => [4, 4, true, 1, 1],
            'set_20' => [4, 5, false, 1, 0],
            'set_21' => [5, 1, false, 1, 0],
            'set_22' => [5, 2, false, 1, 0],
            'set_23' => [5, 3, false, 1, 0],
            'set_24' => [5, 4, false, 1, 0],
            'set_25' => [5, 5, true, 1, 1],
        ];
    }

    public function convertDataProvider()
    {
        return [
            'set_1'  => [1, 1, 1, 1],
            'set_2'  => [1, 2, 1, 0],
            'set_3'  => [1, 3, 1, 0],
            'set_4'  => [1, 4, 1, 0],
            'set_5'  => [1, 5, 1, 0],
            'set_6'  => [2, 1, 1, 0],
            'set_7'  => [2, 2, 1, 1],
            'set_8'  => [2, 3, 1, 1000],
            'set_9'  => [2, 4, 1, 1000000],
            'set_10' => [2, 5, 1, 0],
            'set_11' => [3, 1, 1, 0],
            'set_12' => [3, 2, 1, 0.001],
            'set_13' => [3, 3, 1, 1],
            'set_14' => [3, 4, 1, 1000],
            'set_15' => [3, 5, 1, 0],
            'set_16' => [4, 1, 1, 0],
            'set_17' => [4, 2, 1, 0.000001],
            'set_18' => [4, 3, 1, 0.001],
            'set_19' => [4, 4, 1, 1],
            'set_20' => [4, 5, 1, 0],
            'set_21' => [5, 1, 1, 0],
            'set_22' => [5, 2, 1, 0],
            'set_23' => [5, 3, 1, 0],
            'set_24' => [5, 4, 1, 0],
            'set_25' => [5, 5, 1, 1],
        ];
    }
}
