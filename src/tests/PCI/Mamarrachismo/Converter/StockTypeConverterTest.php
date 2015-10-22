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

    public function validateDataProvider()
    {
        return [
            'set_1'  => [1, 1, true],
            'set_2'  => [1, 2, false],
            'set_3'  => [1, 3, false],
            'set_4'  => [1, 4, false],
            'set_5'  => [1, 5, false],
            'set_6'  => [2, 1, false],
            'set_7'  => [2, 2, true],
            'set_8'  => [2, 3, true],
            'set_9'  => [2, 4, true],
            'set_10' => [2, 5, false],
            'set_11' => [3, 1, false],
            'set_12' => [3, 2, true],
            'set_13' => [3, 3, true],
            'set_14' => [3, 4, true],
            'set_15' => [3, 5, false],
            'set_16' => [4, 1, false],
            'set_17' => [4, 2, true],
            'set_18' => [4, 3, true],
            'set_19' => [4, 4, true],
            'set_20' => [4, 5, false],
            'set_21' => [5, 1, false],
            'set_22' => [5, 2, false],
            'set_23' => [5, 3, false],
            'set_24' => [5, 4, false],
            'set_25' => [5, 5, true],
        ];
    }
}
