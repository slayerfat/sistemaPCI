<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Depot;
use PCI\Models\Item;
use PCI\Models\ItemType;
use PCI\Models\Maker;
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
}
