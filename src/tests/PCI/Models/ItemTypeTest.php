<?php namespace Tests\PCI\Models;

use PCI\Models\Item;
use PCI\Models\ItemType;
use Tests\AbstractPhpUnitTestCase;

class ItemTypeTest extends AbstractPhpUnitTestCase
{

    public function testItems()
    {
        $this->mockBasicModelRelation(
            ItemType::class,
            'items',
            'hasMany',
            Item::class
        );
    }
}
