<?php namespace Tests\Integration\Item;

use Illuminate\Support\Collection;
use InvalidArgumentException;
use LogicException;
use Mockery;
use PCI\Events\Note\NewItemIngress;
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
        $collection = collect();
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
                    'quantity' => 1,
                ],
            ],
            'set_2' => [
                [
                    'item_id'  => 1,
                    'depot_id' => 1,
                    'due'      => '1999-09-09',
                    'quantity' => 1,
                ],
                [
                    'item_id'  => 1,
                    'depot_id' => 1,
                    'due'      => '1999-09-09',
                    'quantity' => 1,
                ],
                [
                    'item_id'  => 1,
                    'depot_id' => 1,
                    'due'      => '1999-09-09',
                    'quantity' => 1,
                ],
            ],
        ];
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage El arreglo de datos, esta construido
     *                           incorrectamente.
     * @dataProvider             emptyCollectionDataProvider
     * @param $data
     */
    public function testClassShouldThrowInvalidArgumentException($data)
    {
        $collection = collect();
        $collection->push($data);
        $note        = Mockery::mock(Note::class)->makePartial();
        $note->items = new Stdclass;

        /** @var Note $note */
        $ingress = new NewItemIngress($note, $collection);
        $this->assertNotEmpty($ingress->getData());
        $this->assertInstanceOf(Collection::class, $ingress->getData());
    }

    /**
     * @expectedException LogicException
     * @expectedExceptionMessage El arreglo de datos, debe contener el id del
     *                           item y elementos asociados.
     */
    public function testClassShouldThrowLogicException()
    {
        $collection  = collect();
        $note        = Mockery::mock(Note::class)->makePartial();
        $note->items = new Stdclass;

        /** @var Note $note */
        $ingress = new NewItemIngress($note, $collection);
        $this->assertNotEmpty($ingress->getData());
        $this->assertInstanceOf(Collection::class, $ingress->getData());
    }

    public function emptyCollectionDataProvider()
    {
        return [
            'set_1' => [[]],
            'set_2' => [
                [
                    'depot_id' => 1,
                    'due'      => '1999-09-09',
                    'quantity' => 1,
                ],
            ],
            'set_3' => [
                [
                    'item_id'  => 1,
                    'due'      => '1999-09-09',
                    'quantity' => 1,
                ],
            ],
            'set_4' => [
                [
                    'item_id'  => 1,
                    'depot_id' => 1,
                    'quantity' => 1,
                ],
            ],
            'set_5' => [
                [
                    'item_id'  => 1,
                    'depot_id' => 1,
                    'due'      => '1999-09-09',
                ],
            ],
        ];
    }
}
