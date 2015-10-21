<?php namespace Tests\PCI\Models\Item;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PCI\Models\Depot;
use PCI\Models\Item;
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

    public function testStockShouldReturnACeroWhenNoQuantityFound()
    {
        $this->assertEquals(0, $this->item->stock);
        $this->assertEquals(0, $this->item->percentageStock());
    }

    public function testStockShouldReturnAValidNumber()
    {
        $depots = factory(Depot::class, 3)->create();

        foreach ($depots as $depot) {
            $this->item->depots()->attach($depot->id, [
                'quantity'      => 10,
                'stock_type_id' => 1,
            ]);
        }

        $this->assertEquals(30, $this->item->stock);
        $this->assertEquals(50, $this->item->percentageStock());
    }

    public function testFormattedStockShouldReturnValidNumbers()
    {
        $depots = factory(Depot::class, 3)->create();

        foreach ($depots as $depot) {
            $this->item->depots()->attach($depot->id, [
                'quantity'      => 12,
                'stock_type_id' => 1,
            ]);
        }

        $this->assertEquals('36 Unidades', $this->item->formattedStock());

        foreach ($depots as $depot) {
            $this->item->depots()->detach($depot->id);
        }

        $this->assertEquals('0 Unidades', $this->item->formattedStock());

        $this->item->depots()->attach(
            $depots->first()->id,
            [
                'quantity'      => 1,
                'stock_type_id' => 1,
            ]
        );

        $this->assertEquals('1 Unidad', $this->item->formattedStock());
    }

    public function testFormattedStockShouldReturnCorrectType()
    {
        $depots = factory(Depot::class, 2)->create();

        $stock = StockType::whereDesc('Tonelada')->first();

        $this->item->stock_type_id = $stock->id;
        $this->item->save();

        $this->assertEquals('Tonelada', $this->item->stockType->desc);

        foreach ($depots as $depot) {
            $this->item->depots()->attach($depot->id, [
                'quantity'      => 12,
                'stock_type_id' => 2,
            ]);
        }

        $this->assertEquals('24 Toneladas', $this->item->formattedStock());
    }

    public function testItemShouldReturnCorrectStockConversion()
    {
        $depots = factory(Depot::class, 3)->create();
        $i = 1;
        $item = $this->item = factory(Item::class, 'full')->create(
            ['minimum' => 50, 'stock_type_id' => 3]
        );

        foreach ($depots as $depot) {
            $this->item->depots()->attach($depot->id, [
                'quantity'      => 1,
                'stock_type_id' => $i++,
            ]);
        }

        $this->assertEquals('1001.1 Kilos', $item->formattedStock());

        $this->markTestIncomplete();
    }

    private function createStockTypes()
    {
        $data = ['Unidad', 'Gramo', 'Kilo', 'Tonelada', 'Lata'];

        foreach ($data as $value) {
            factory(StockType::class)->create(['desc' => $value]);
        }
    }
}
