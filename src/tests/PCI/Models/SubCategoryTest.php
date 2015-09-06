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
        $model = Mockery::mock(SubCategory::class)->makePartial();

        $model->shouldReceive('belongsTo')
            ->once()
            ->with(Category::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->category());
    }

    public function testItems()
    {
        $model = Mockery::mock(SubCategory::class)->makePartial();

        $model->shouldReceive('hasMany')
            ->once()
            ->with(Item::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->items());
    }
}
