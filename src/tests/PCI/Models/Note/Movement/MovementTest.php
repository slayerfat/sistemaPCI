<?php namespace Tests\PCI\Models\Note\Movement;

use Mockery;
use PCI\Models\ItemMovement;
use PCI\Models\Movement;
use PCI\Models\MovementType;
use PCI\Models\Note;
use Tests\AbstractTestCase;

class MovementTest extends AbstractTestCase
{

    public function testType()
    {
        $mock = Mockery::mock(Movement::class)->makePartial();

        $mock->shouldReceive('belongsTo')
            ->once()
            ->with(MovementType::class, 'movement_type_id')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $mock->type());
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

    public function testItemMovements()
    {
        $this->mockBasicModelRelation(
            Movement::class,
            'itemMovements',
            'hasMany',
            ItemMovement::class
        );
    }
}
