<?php namespace Tests\PCI\Models\Note\Movement;

use Mockery;
use PCI\Models\Item;
use PCI\Models\Movement;
use PCI\Models\MovementType;
use PCI\Models\Note;
use Tests\BaseTestCase;

class MovementTest extends BaseTestCase
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

    public function testNote()
    {
        $this->mockBasicModelRelation(
            Movement::class,
            'note',
            'belongsTo',
            Note::class
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
