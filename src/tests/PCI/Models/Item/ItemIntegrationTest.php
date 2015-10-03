<?php namespace Tests\PCI\Models\Item;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PCI\Models\Depot;
use PCI\Models\Item;
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
            $this->item->depots()->attach($depot->id, ['quantity'      => 10,
                                                       'stock_type_id' => 1
            ]);
        }

        $this->assertEquals(30, $this->item->stock);
        $this->assertEquals(50, $this->item->percentageStock());
    }
}
