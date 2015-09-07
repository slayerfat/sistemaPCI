<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Depot;
use PCI\Models\Employee;
use PCI\Models\Item;
use Tests\AbstractPhpUnitTestCase;

class DepotTest extends AbstractPhpUnitTestCase
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
