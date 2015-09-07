<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Category;
use PCI\Models\SubCategory;
use Tests\AbstractPhpUnitTestCase;

class CategoryTest extends AbstractPhpUnitTestCase
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
