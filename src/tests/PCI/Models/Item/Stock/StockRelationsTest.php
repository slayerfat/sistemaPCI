<?php namespace Tests\PCI\Models\Item\Stock;

use Mockery;
use PCI\Models\Depot;
use PCI\Models\Item;
use PCI\Models\Stock;
use PCI\Models\StockDetail;
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
        $model = Mockery::mock(Stock::class)->makePartial();

        $model->shouldReceive('belongsTo')
            ->once()
            ->with(StockType::class, 'stock_type_id')
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->type());
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

    public function testDetails()
    {
        $this->mockBasicModelRelation(
            Stock::class,
            'details',
            'hasMany',
            StockDetail::class
        );
    }
}
