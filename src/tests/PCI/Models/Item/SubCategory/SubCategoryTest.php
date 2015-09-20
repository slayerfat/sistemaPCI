<?php namespace Tests\PCI\Models\Item\SubCategory;

use Mockery;
use PCI\Models\Category;
use PCI\Models\Item;
use PCI\Models\SubCategory;
use Tests\AbstractTestCase;

class SubCategoryTest extends AbstractTestCase
{

    public function testCategory()
    {
        $this->mockBasicModelRelation(
            SubCategory::class,
            'category',
            'belongsTo',
            Category::class
        );
    }

    public function testItems()
    {
        $this->mockBasicModelRelation(
            SubCategory::class,
            'items',
            'hasMany',
            Item::class
        );
    }
}
