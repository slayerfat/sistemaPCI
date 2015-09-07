<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Item;
use PCI\Models\Movement;
use PCI\Models\MovementType;
use Tests\AbstractPhpUnitTestCase;

class MovementTest extends AbstractPhpUnitTestCase
{

    public function testType()
    {
        $this->mockBasicModelRelation(
            Movement::class,
            'type',
            'belongsTo',
            MovementType::class
        );
    }

    public function testItems()
    {
        $mock = Mockery::mock(Movement::class)->makePartial();

        $mock->shouldReceive('belongsToMany')
            ->once()
            ->with(Item::class)
            ->andReturnSelf();

        $mock->shouldReceive('withPivot')
            ->once()
            ->with('quantity')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $mock->items());
    }
}
