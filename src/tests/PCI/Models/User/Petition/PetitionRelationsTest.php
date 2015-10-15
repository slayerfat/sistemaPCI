<?php namespace Tests\PCI\Models\User\Petition;

use Mockery;
use PCI\Models\Item;
use PCI\Models\Note;
use PCI\Models\Petition;
use PCI\Models\PetitionType;
use PCI\Models\User;
use Tests\AbstractTestCase;

class PetitionRelationsTest extends AbstractTestCase
{

    public function testType()
    {
        $mock = Mockery::mock(Petition::class)->makePartial();

        $mock->shouldReceive('belongsTo')
             ->once()
             ->with(PetitionType::class, 'petition_type_id')
             ->andReturn('mocked');

        $this->assertEquals('mocked', $mock->type());
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
            ->with('quantity', 'stock_type_id')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $mock->items());
    }
}
