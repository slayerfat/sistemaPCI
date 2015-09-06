<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Category;
use PCI\Models\SubCategory;
use Tests\AbstractPhpUnitTestCase;

class CategoryTest extends AbstractPhpUnitTestCase
{

    public function testSubCategories()
    {
        $model = Mockery::mock(Category::class)
            ->makePartial();

        $model->shouldReceive('hasMany')
            ->once()
            ->with(SubCategory::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->subCategories());
    }
}
