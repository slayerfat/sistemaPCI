<?php namespace Tests\Integration\Item;

use Illuminate\Support\Collection;
use Mockery;
use PCI\Events\Note\NewItemIngress;
use PCI\Mamarrachismo\Collection\ItemCollection;
use PCI\Models\Note;
use stdClass;
use Tests\AbstractTestCase;

/**
 * Class NewItemIngressTest
 *
 * @package Tests\Integration\Item
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class NewItemIngressTest extends AbstractTestCase
{

    /**
     * @dataProvider collectionDataProvider
     * @param $data
     */
    public function testClassShouldCheckCollection($data)
    {
        $collection = new ItemCollection;
        $collection->push($data);
        $note        = Mockery::mock(Note::class)->makePartial();
        $note->items = new Stdclass;

        /** @var Note $note */
        $ingress = new NewItemIngress($note, $collection);
        $this->assertNotEmpty($ingress->getData());
        $this->assertInstanceOf(Collection::class, $ingress->getData());
    }

    public function collectionDataProvider()
    {
        return [
            'set_1' => [
                [
                    'item_id'  => 1,
                    'depot_id' => 1,
                    'due'      => '1999-09-09',
                    'amount'   => 1,
                ],
            ],
            'set_2' => [
                [
                    'item_id'  => 1,
                    'depot_id' => 1,
                    'due'      => '1999-09-09',
                    'amount'   => 1,
                ],
                [
                    'item_id'  => 1,
                    'depot_id' => 1,
                    'due'      => '1999-09-09',
                    'amount'   => 1,
                ],
                [
                    'item_id'  => 1,
                    'depot_id' => 1,
                    'due'      => '1999-09-09',
                    'amount'   => 1,
                ],
            ],
        ];
    }
}
