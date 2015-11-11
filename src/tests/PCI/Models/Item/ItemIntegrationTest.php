<?php namespace Tests\PCI\Models\Item;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PCI\Models\Item;
use PCI\Models\Stock;
use PCI\Models\StockType;
use Tests\AbstractTestCase;

class ItemIntegrationTest extends AbstractTestCase
{

    use DatabaseMigrations, DatabaseTransactions;

    /**
     * @var \PCI\Models\Item
     */
    private $item;

    public function setUp()
    {
        parent::setUp();

        $this->runDatabaseMigrations();
        $this->createStockTypes();

        $this->item = factory(Item::class, 'full')->create(
            ['minimum' => 60, 'stock_type_id' => 1]
        );
    }

    public static function createStockTypes()
    {
        $data = ['Unidad', 'Gramo', 'Kilo', 'Tonelada', 'Lata'];

        foreach ($data as $value) {
            factory(StockType::class)->create(['desc' => $value]);
        }
    }

    public function testStockShouldReturnACeroWhenNoQuantityFound()
    {
        $this->assertEquals(0, $this->item->stock());
        $this->assertEquals(0, $this->item->percentageStock());
    }

    public function testStockShouldReturnAValidNumber()
    {
        factory(Stock::class, 3)->create([
            'item_id'       => $this->item->id,
            'total'         => 10,
            'stock_type_id' => 1,
        ]);

        $this->assertEquals(30, $this->item->stock());
        $this->assertEquals(50, $this->item->percentageStock());
    }

    public function testFormattedStockShouldReturnMoreThanOneNumber()
    {
        factory(Stock::class, 3)->create([
            'item_id'       => $this->item->id,
            'total'         => 12,
            'stock_type_id' => 1,
        ]);

        $this->assertEquals('36 Unidades', $this->item->formattedStock());
    }

    public function testFormattedStockShouldReturnCeroNumbers()
    {
        $item = factory(Item::class, 'full')->create(['stock_type_id' => 1]);

        $this->assertEquals('0 Unidades', $item->formattedStock());
    }

    public function testFormattedStockShouldReturnOneNumber()
    {
        factory(Stock::class)->create([
            'item_id'       => $this->item->id,
            'total'         => 1,
            'stock_type_id' => 1,
        ]);

        $this->assertEquals('1 Unidad', $this->item->formattedStock());
    }

    public function testFormattedStockShouldReturnCorrectType()
    {
        $stock = StockType::whereDesc('Tonelada')->first();
        $item  = factory(Item::class)->create(['stock_type_id' => $stock->id]);

        factory(Stock::class, 2)->create([
            'item_id'       => $item->id,
            'total'         => 12,
            'stock_type_id' => $stock->id,
        ]);

        $this->assertEquals('24 Toneladas', $item->formattedStock());
    }

    /**
     * @param $id
     * @param $message
     * @dataProvider stockTypeConversionDataProvider
     */
    public function testItemShouldReturnCorrectStockConversion($id, $message)
    {
        $item = $this->item = factory(Item::class, 'full')->create(
            ['minimum' => 50, 'stock_type_id' => $id]
        );

        for ($i = 2; $i <= 4; $i++) {
            factory(Stock::class)->create([
                'item_id'       => $item->id,
                'total'         => 1,
                'stock_type_id' => $i,
            ]);
        }

        $this->assertEquals($message, $item->formattedStock());
    }

    public function stockTypeConversionDataProvider()
    {
        return [
            'set_1' => [1, '3 Unidades'],
            'set_2' => [2, '1001001 Gramos'],
            'set_3' => [3, '1001.001 Kilos'],
            'set_4' => [4, '1.001001 Toneladas'],
            'set_5' => [5, '3 Latas'],
        ];
    }

    /**
     * @param $id
     * @param $reserved
     * @param $message
     * @dataProvider stockTypeConversionWithReserveDataProvider
     */
    public function testItemShouldAllowReservedStock($id, $reserved, $message)
    {
        $item = $this->item = factory(Item::class, 'full')->create(
            ['minimum' => 50, 'stock_type_id' => $id]
        );

        $this->item->reserved = $reserved;

        for ($i = 2; $i <= 4; $i++) {
            factory(Stock::class)->create([
                'item_id'       => $item->id,
                'total'         => 1,
                'stock_type_id' => $i,
            ]);
        }

        $this->assertEquals($message, $item->formattedStock());
    }

    public function stockTypeConversionWithReserveDataProvider()
    {
        return [
            'set_1'      => [1, 1, '2 Unidades'],
            'set_1_0'    => [1, 0, '3 Unidades'],
            'set_1_-1'   => [1, -4, '3 Unidades'],
            'set_1_a'    => [1, 'a', '3 Unidades'],
            'set_1_null' => [1, null, '3 Unidades'],
            'set_2'      => [2, 1, '1001000 Gramos'],
            'set_3'      => [3, 1, '1000.001 Kilos'],
            'set_3_0'    => [3, 0, '1001.001 Kilos'],
            'set_3_null' => [3, null, '1001.001 Kilos'],
            'set_3_-1'   => [3, -2000, '1001.001 Kilos'],
            'set_3_a'    => [3, 'a', '1001.001 Kilos'],
            'set_4'      => [4, 1, '0.001001 Toneladas'],
            'set_5'      => [5, 1, '2 Latas'],
            'set_5_0'    => [5, 0, '3 Latas'],
            'set_5_null' => [5, null, '3 Latas'],
            'set_5_-1'   => [5, -5, '3 Latas'],
            'set_5_a'    => [5, 'a', '3 Latas'],
        ];
    }
}
