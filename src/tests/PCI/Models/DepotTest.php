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
        $model = Mockery::mock(Depot::class)
            ->makePartial();

        $model->shouldReceive('belongsTo')
            ->once()
            ->with(Employee::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->owner());
    }


    public function testItems()
    {
        $model = \Mockery::mock(Depot::class)
            ->makePartial();

        $model->shouldReceive('belongsToMany')
            ->once()
            ->with(Item::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->items());
    }
}
