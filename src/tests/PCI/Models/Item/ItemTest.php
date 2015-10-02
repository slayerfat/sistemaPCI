<?php namespace Tests\PCI\Models\Item;

use PCI\Models\Item;
use Tests\AbstractTestCase;

class ItemTest extends AbstractTestCase
{

    /**
     * @var \PCI\Models\Item
     */
    private $item;

    public function setUp()
    {
        parent::setUp();

        $this->item = factory(Item::class, 'full')->make();
    }

    public function testStockShouldReturnAValidNumber()
    {
        $this->markTestIncomplete();

        $this->assertEquals(1, $this->item->stock);
    }
}
