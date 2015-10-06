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

        $this->item = factory(Item::class, 'full')->create(['minimum' => 60]);
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
                'stock_type_id' => 1
            ]);
        }

        $this->assertEquals(30, $this->item->stock);
        $this->assertEquals(50, $this->item->percentageStock());
    }

    public function testFormattedStockShouldReturnValidNumbers()
    {
        $depots     = factory(Depot::class, 3)->create();
        $type       = StockType::first();
        $type->desc = 'Unidad';
        $type->save();

        foreach ($depots as $depot) {
            $this->item->depots()->attach($depot->id, [
                'quantity'      => 12,
                'stock_type_id' => 1
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
                'stock_type_id' => 1
            ]
        );

        $this->assertEquals('1 Unidad', $this->item->formattedStock());
    }

    public function testFormattedStockShouldReturnCorrectType()
    {
        $depots     = factory(Depot::class, 2)->create();
        $type       = StockType::first();
        $type->desc = 'Unidad';
        $type->save();

        $stock = factory(StockType::class)->create(['desc' => 'Tonelada']);

        $this->item->stock_type_id = $stock->id;
        $this->item->save();

        $this->assertEquals('Tonelada', $this->item->stockType->desc);

        foreach ($depots as $depot) {
            $this->item->depots()->attach($depot->id, [
                'quantity'      => 12,
                'stock_type_id' => 2
            ]);
        }

        $this->assertEquals('24 Toneladas', $this->item->formattedStock());
    }
}
