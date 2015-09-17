<?php namespace Tests\PCI\Models\Item\Maker;

use Mockery;
use PCI\Models\Item;
use PCI\Models\Maker;
use Tests\BaseTestCase;

class MakerTest extends BaseTestCase
{

    public function testItems()
    {
        $this->mockBasicModelRelation(
            Maker::class,
            'items',
            'hasMany',
            Item::class
        );
    }
}
