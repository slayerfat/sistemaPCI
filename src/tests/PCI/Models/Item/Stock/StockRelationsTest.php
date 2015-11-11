<?php namespace Tests\PCI\Models\Item\Stock;

use PCI\Models\Depot;
use PCI\Models\Item;
use PCI\Models\ItemMovement;
use PCI\Models\Stock;
use PCI\Models\StockType;
use Tests\AbstractTestCase;

/**
 * Class StockRelationsTest
 *
 * @package Tests\PCI\Models\Item\Stock
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class StockRelationsTest extends AbstractTestCase
{

    public function testType()
    {
        $this->mockBasicModelRelation(
            Stock::class,
            'type',
            'belongsTo',
            StockType::class
        );
    }

    public function testDepot()
    {
        $this->mockBasicModelRelation(
            Stock::class,
            'depot',
            'belongsTo',
            Depot::class
        );
    }

    public function testItem()
    {
        $this->mockBasicModelRelation(
            Stock::class,
            'item',
            'belongsTo',
            Item::class
        );
    }

    public function testItemMovements()
    {
        $this->mockBasicModelRelation(
            Stock::class,
            'itemMovements',
            'hasMany',
            ItemMovement::class
        );
    }
}
