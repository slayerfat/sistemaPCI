<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Item;
use PCI\Models\Maker;
use Tests\AbstractPhpUnitTestCase;

class MakerTest extends AbstractPhpUnitTestCase
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
