<?php namespace Tests\PCI\Models\Item\Stock;

use PCI\Models\Stock;
use PCI\Models\StockDetail;
use Tests\AbstractTestCase;

/**
 * Class StockDetailRelationsTest
 *
 * @package Tests\PCI\Models\Item\Stock
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class StockDetailRelationsTest extends AbstractTestCase
{

    public function testStock()
    {
        $this->mockBasicModelRelation(
            StockDetail::class,
            'stock',
            'belongsTo',
            Stock::class
        );
    }
}
