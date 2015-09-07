<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Category;
use PCI\Models\Item;
use PCI\Models\SubCategory;
use Tests\AbstractPhpUnitTestCase;

class SubCategoryTest extends AbstractPhpUnitTestCase
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
