<?php namespace Tests\PCI\Models\Item\Type;

use PCI\Models\Item;
use PCI\Models\ItemType;
use Tests\AbstractTestCase;

class ItemTypeTest extends AbstractTestCase
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
