<?php namespace Tests\PCI\Models\Note;

use Mockery;
use PCI\Models\Attendant;
use PCI\Models\Item;
use PCI\Models\Movement;
use PCI\Models\Note;
use PCI\Models\NoteType;
use PCI\Models\Petition;
use PCI\Models\User;
use Tests\AbstractTestCase;

class NoteTest extends AbstractTestCase
{
    public function testPetition()
    {
        $this->mockBasicModelRelation(
            Note::class,
            'petition',
            'belongsTo',
            Petition::class
        );
    }

    public function testRequestedBy()
    {
        $mock = Mockery::mock(Note::class)->makePartial();

        $mock->shouldReceive('belongsTo')
            ->once()
            ->with(User::class, 'user_id')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $mock->requestedBy());
    }

    public function testToUser()
    {
        $mock = Mockery::mock(Note::class)->makePartial();

        $mock->shouldReceive('belongsTo')
            ->once()
            ->with(User::class, 'to_user_id')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $mock->toUser());
    }

    public function testAttendant()
    {
        $this->mockBasicModelRelation(
            Note::class,
            'attendant',
            'belongsTo',
            Attendant::class
        );
    }

    public function testType()
    {
        $mock = Mockery::mock(Note::class)->makePartial();

        $mock->shouldReceive('belongsTo')
            ->once()
            ->with(NoteType::class, 'note_type_id')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $mock->type());
    }

    public function testMovements()
    {
        $this->mockBasicModelRelation(
            Note::class,
            'movements',
            'hasMany',
            Movement::class
        );
    }

    public function testItems()
    {
        $mock = Mockery::mock(Note::class)->makePartial();

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
