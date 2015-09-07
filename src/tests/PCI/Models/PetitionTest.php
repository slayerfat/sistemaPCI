<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Item;
use PCI\Models\Note;
use PCI\Models\Petition;
use PCI\Models\PetitionType;
use PCI\Models\User;
use Tests\AbstractPhpUnitTestCase;

class PetitionTest extends AbstractPhpUnitTestCase
{

    public function testType()
    {
        $this->mockBasicModelRelation(
            Petition::class,
            'type',
            'belongsTo',
            PetitionType::class
        );
    }

    public function testUser()
    {
        $this->mockBasicModelRelation(
            Petition::class,
            'user',
            'belongsTo',
            User::class
        );
    }

    public function testNotes()
    {
        $this->mockBasicModelRelation(
            Petition::class,
            'notes',
            'hasMany',
            Note::class
        );
    }

    public function testItems()
    {
        $mock = Mockery::mock(Petition::class)->makePartial();

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
