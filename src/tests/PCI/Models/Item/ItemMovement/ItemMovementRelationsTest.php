<?php namespace Tests\PCI\Models\Item\ItemMovement;

use PCI\Models\Item;
use PCI\Models\ItemMovement;
use PCI\Models\Movement;
use PCI\Models\Stock;
use Tests\AbstractTestCase;

/**
 * Class ItemMovementRelationsTest
 *
 * @package Tests\PCI\Models\Item\ItemMovement
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class ItemMovementRelationsTest extends AbstractTestCase
{

    public function testMovement()
    {
        $this->mockBasicModelRelation(
            ItemMovement::class,
            'movement',
            'belongsTo',
            Movement::class
        );
    }

    public function testItem()
    {
        $this->mockBasicModelRelation(
            ItemMovement::class,
            'item',
            'belongsTo',
            Item::class
        );
    }

    public function testStock()
    {
        $this->mockBasicModelRelation(
            ItemMovement::class,
            'stock',
            'belongsTo',
            Stock::class
        );
    }
}
