<?php namespace Tests\PCI\Models\Item\Depot;

use Mockery;
use PCI\Models\Depot;
use PCI\Models\Stock;
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
        // v0.4.4
        $this->mockBasicModelRelation(
            Depot::class,
            'stocks',
            'hasMany',
            Stock::class
        );
    }
}
