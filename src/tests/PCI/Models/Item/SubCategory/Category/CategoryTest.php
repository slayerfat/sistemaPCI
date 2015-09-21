<?php namespace Tests\PCI\Models\Item\SubCategory\Category;

use Mockery;
use PCI\Models\Category;
use PCI\Models\SubCategory;
use Tests\AbstractTestCase;

class CategoryTest extends AbstractTestCase
{

    public function testSubCategories()
    {
        $this->mockBasicModelRelation(
            Category::class,
            'subCategories',
            'hasMany',
            SubCategory::class
        );
    }
}
