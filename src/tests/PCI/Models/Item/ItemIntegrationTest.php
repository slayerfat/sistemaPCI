<?php namespace Tests\PCI\Models\Item;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
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

        $this->item = factory(Item::class, 'full')->make();
    }
}
