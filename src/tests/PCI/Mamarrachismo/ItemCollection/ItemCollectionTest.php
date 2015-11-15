<?php namespace Tests\PCI\Mamarrachismo\ItemCollection;

use PCI\Mamarrachismo\Collection\ItemCollection;
use Tests\AbstractPhpUnitTestCase;

/**
 * Class ItemCollectionTest
 *
 * @package Tests\PCI\Mamarrachismo\ItemCollection
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class ItemCollectionTest extends AbstractPhpUnitTestCase
{

    /**
     * @var \PCI\Mamarrachismo\Collection\ItemCollection
     */
    private $obj;

    /**
     * @dataProvider dataProvider
     * @param $value
     * @param $expecting
     * @param $method
     */
    public function testItemId($value, $expecting, $method)
    {
        $set = "set$method";
        $get = "get$method";
        $this->assertEquals($expecting, $this->obj->$set($value)->$get());
    }

    public function dataProvider()
    {
        $results = [];
        $inputs  = [
            'one'             => [1, 1],
            'int'             => [2, 2],
            'cero'            => [0, null],
            'negative'        => [-1, null],
            'string_valid'    => ["1", 1],
            'string_invalid'  => ["a", null],
            'string_cero'     => [0, null],
            'string_negative' => [-1, null],
        ];

        $methods = ['ItemId', 'Amount', 'StockTypeId'];
        foreach ($inputs as $data) {
            foreach ($methods as $method) {
                $set       = $data;
                $set[]     = $method;
                $results[] = $set;
            }
        }

        return $results;
    }

    /**
     * @dataProvider dueDataProvider
     * @param $value
     * @param $expecting
     */
    public function testDueDate($value, $expecting)
    {
        $this->assertEquals($expecting, $this->obj->setDue($value)->getDue());
    }

    public function dueDataProvider()
    {
        return [
            [1, null],
            [0, null],
            [-1, null],
            ["1", null],
            ["0", null],
            ["a", null],
            ["b", null],
            ["c", null],
            [[], null],
            ["1999", null],
            ["1999-09", '1999-09-01 00:00:00'],
            ["1999-09-09", '1999-09-09 00:00:00'],
        ];
    }

    protected function setUp()
    {
        parent::setUp();

        $this->obj = new ItemCollection;
    }
}
