<?php namespace Tests\PCI\Models\Item\Depot;

use Mockery;
use PCI\Models\Depot;
use PCI\Models\Item;
use PCI\Models\User;
use Tests\AbstractTestCase;

class DepotTest extends AbstractTestCase
{

    public function testOwner()
    {
        $model = Mockery::mock(Depot::class)->makePartial();

        $model->shouldReceive('belongsTo')
            ->once()
            ->with(User::class, 'user_id')
            ->andReturn('mocked');

        /** @var Depot $model */
        $this->assertEquals('mocked', $model->owner());
    }

    public function testItems()
    {
        // v0.3.2
        $mock = Mockery::mock(Depot::class)->makePartial();

        $mock->shouldReceive('belongsToMany')
            ->once()
            ->with(Item::class)
            ->andReturnSelf();

        $mock->shouldReceive('withPivot')
            ->once()
            ->with('quantity', 'stock_type_id')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $mock->items());
    }
}
