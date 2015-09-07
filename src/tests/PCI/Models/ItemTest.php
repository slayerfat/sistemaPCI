<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Depot;
use PCI\Models\Item;
use PCI\Models\ItemType;
use PCI\Models\Maker;
use PCI\Models\Movement;
use PCI\Models\Note;
use PCI\Models\Petition;
use PCI\Models\SubCategory;
use Tests\AbstractPhpUnitTestCase;

class ItemTest extends AbstractPhpUnitTestCase
{

    public function testSubCategory()
    {
        $this->mockBasicModelRelation(
            Item::class,
            'subCategory',
            'belongsTo',
            SubCategory::class
        );
    }

    public function testMaker()
    {
        $this->mockBasicModelRelation(
            Item::class,
            'maker',
            'belongsTo',
            Maker::class
        );
    }

    public function testType()
    {
        $this->mockBasicModelRelation(
            Item::class,
            'type',
            'belongsTo',
            ItemType::class
        );
    }

    public function testDepots()
    {
        $this->mockBasicModelRelation(
            Item::class,
            'depots',
            'belongsToMany',
            Depot::class
        );
    }

    public function testDependsOn()
    {
        $this->mockBasicModelRelation(
            Item::class,
            'dependsOn',
            'belongsToMany',
            Item::class
        );
    }

    public function testPetitions()
    {
        $mock = Mockery::mock(Item::class)->makePartial();

        $mock->shouldReceive('belongsToMany')
            ->once()
            ->with(Petition::class)
            ->andReturnSelf();

        $mock->shouldReceive('withPivot')
            ->once()
            ->with('quantity')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $mock->petitions());
    }

    public function testMovements()
    {
        $mock = Mockery::mock(Item::class)->makePartial();

        $mock->shouldReceive('belongsToMany')
            ->once()
            ->with(Movement::class)
            ->andReturnSelf();

        $mock->shouldReceive('withPivot')
            ->once()
            ->with('quantity')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $mock->movements());
    }

    public function testNotes()
    {
        $mock = Mockery::mock(Item::class)->makePartial();

        $mock->shouldReceive('belongsToMany')
            ->once()
            ->with(Note::class)
            ->andReturnSelf();

        $mock->shouldReceive('withPivot')
            ->once()
            ->with('quantity')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $mock->notes());
    }
}
