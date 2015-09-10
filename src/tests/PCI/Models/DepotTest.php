<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Depot;
use PCI\Models\Employee;
use PCI\Models\Item;
use Tests\BaseTestCase;

class DepotTest extends BaseTestCase
{

    public function testOwner()
    {
        $this->mockBasicModelRelation(
            Depot::class,
            'owner',
            'belongsTo',
            Employee::class
        );
    }


    public function testItems()
    {
        $this->mockBasicModelRelation(
            Depot::class,
            'items',
            'belongsToMany',
            Item::class
        );
    }
}
