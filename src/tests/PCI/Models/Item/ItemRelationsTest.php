<?php namespace Tests\PCI\Models\Item;

use Mockery;
use PCI\Models\Depot;
use PCI\Models\Item;
use PCI\Models\ItemType;
use PCI\Models\Maker;
use PCI\Models\Movement;
use PCI\Models\Note;
use PCI\Models\Petition;
use PCI\Models\SubCategory;
use Tests\AbstractTestCase;

class ItemRelationsTest extends AbstractTestCase
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
        $model = Mockery::mock(Item::class)->makePartial();

        $model->shouldReceive('belongsTo')
              ->once()
              ->with(ItemType::class, 'item_type_id')
              ->andReturn('mocked');

        $this->assertEquals('mocked', $model->type());
    }

    public function testDepots()
    {
        // v0.3.2
        $mock = Mockery::mock(Item::class)->makePartial();

        $mock->shouldReceive('belongsToMany')
             ->once()
             ->with(Depot::class)
             ->andReturnSelf();

        $mock->shouldReceive('withPivot')
             ->once()
             ->with('quantity')
             ->andReturn('mocked');

        $this->assertEquals('mocked', $mock->depots());
    }

    public function testDependsOn()
    {
        $mock = Mockery::mock(Item::class)->makePartial();

        $mock->shouldReceive('belongsToMany')
            ->once()
            ->with(
                Item::class,
                'item_item',
                'item_id',
                'depends_on_id'
            )->andReturn('mocked');

        $this->assertEquals('mocked', $mock->dependsOn());
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
            ->with('quantity', 'stock_type_id')
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
            ->with('quantity', 'due')
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
