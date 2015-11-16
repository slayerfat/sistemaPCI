<?php namespace Tests\Integration\Item;

use PCI\Events\Note\NewItemIngress;
use PCI\Listeners\Note\GenerateItemIngress;
use PCI\Mamarrachismo\Collection\ItemCollection;
use PCI\Mamarrachismo\Converter\interfaces\StockTypeConverterInterface;
use PCI\Models\Depot;
use PCI\Models\Item;
use PCI\Models\Movement;
use PCI\Models\MovementType;
use PCI\Models\Note;
use PCI\Models\NoteType;
use PCI\Models\StockType;
use Tests\Integration\User\AbstractUserIntegration;
use Tests\PCI\Models\Item\ItemIntegrationTest;

/**
 * Class GenerateItemIngressTest
 *
 * @package Tests\Integration\Item
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class GenerateItemIngressTest extends AbstractUserIntegration
{

    /**
     * @var \PCI\Listeners\Note\GenerateItemIngress
     */
    public $event;

    /**
     * @var \PCI\Models\Item
     */
    public $item;

    public function setUp()
    {
        parent::setUp();

        /** @var StockTypeConverterInterface $converter */
        $converter   = $this->app[StockTypeConverterInterface::class];
        $this->event = new GenerateItemIngress($converter, new Movement, collect());
    }

    /**
     * @dataProvider itemIngressDataProvider
     * @param $initialData
     * @param $finalStock
     * @param $events
     */
    public function testItemIngressShouldPersist(
        $initialData,
        $finalStock,
        $events
    ) {
        $this->item->stock_type_id = 1;
        $this->item->save();
        factory(Depot::class, 3)->create();
        $collection = new ItemCollection;
        $collection->addRule('stockTypeId');

        /** @var Note $note */
        $note = factory(Note::class)->create(['note_type_id' => 1]);
        foreach ($initialData as $array) {
            foreach ($array as $id => $data) {
                $note->petition->items()->attach($this->item->id, [
                    'quantity'      => $data['amount'],
                    'stock_type_id' => 1,
                ]);

                $note->items()->attach($this->item->id, [
                    'quantity'      => $data['amount'],
                    'stock_type_id' => 1,
                    'due'           => $data['due'],
                ]);

                $collection->push([
                    'item_id'       => $this->item->id,
                    'depot_id'      => $id,
                    'due'           => $data['due'],
                    'amount'        => $data['amount'],
                    'stock_type_id' => 1,
                ]);
            }
        }

        $note->fresh();
        $newEgress = new NewItemIngress($note, $collection);

        if ($events) {
            $this->expectsEvents($events)
                ->event->handle($newEgress);
        } elseif (is_null($events)) {
            $this->event->handle($newEgress);
        }

        foreach ($finalStock as $array) {
            foreach ($array as $id => $amount) {
                if (is_null($amount)) {
                    $this->notSeeInDatabase('stocks', [
                        'depot_id' => $id,
                        'item_id'  => $this->item->id,
                    ]);
                } elseif (!is_null($amount)) {
                    $this->seeInDatabase('stocks', [
                        'depot_id' => $id,
                        'item_id'  => $this->item->id,
                    ]);
                    $this->seeInDatabase('item_movements', [
                        'item_id'  => $this->item->id,
                    ]);
                    $this->seeInDatabase('stock_details', [
                        'quantity' => $amount,
                    ]);
                }
            }
        }
    }

    /**
     * @return array
     */
    public function itemIngressDataProvider()
    {
        return [
            'prueba_01_camino_x' => [
                [
                    [1 => ['amount' => 1, 'due' => null]],
                    [2 => ['amount' => 3, 'due' => null]],
                    [3 => ['amount' => 5, 'due' => null]],
                ],
                [[1 => 1], [2 => 3], [3 => 5]],
                null,
            ],
            'prueba_02_camino_x' => [
                [
                    [1 => ['amount' => 3, 'due' => '1999-09-09']],
                    [1 => ['amount' => 13, 'due' => '1999-09-10']],
                    [1 => ['amount' => 7, 'due' => '1999-09-11']],
                ],
                [[1 => 3], [1 => 13], [1 => 7]],
                null,
            ],
            'prueba_03_camino_x' => [
                [
                    [1 => ['amount' => 23, 'due' => '1999-09-09']],
                    [1 => ['amount' => 13, 'due' => '1999-09-09']],
                    [1 => ['amount' => 29, 'due' => '1999-09-09']],
                ],
                [[1 => 65]],
                null,
            ],
            'prueba_04_camino_x' => [
                [
                    [1 => ['amount' => 1, 'due' => '1999-09-09']],
                    [1 => ['amount' => 1, 'due' => '1999-09-09']],
                    [1 => ['amount' => 1, 'due' => '1999-09-09']],
                ],
                [[1 => 1]],
                null,
            ],
            'prueba_05_camino_x' => [
                [
                    [1 => ['amount' => 1, 'due' => '1999-09-09']],
                    [1 => ['amount' => 7, 'due' => '1999-09-09']],
                    [1 => ['amount' => 13, 'due' => '1999-09-09']],
                ],
                [[1 => 21]],
                null,
            ],
            'prueba_06_camino_x' => [
                [
                    [1 => ['amount' => 31, 'due' => null]],
                    [1 => ['amount' => 33, 'due' => null]],
                    [1 => ['amount' => 37, 'due' => null]],
                ],
                [[1 => 101]],
                null,
            ],
            'prueba_07_camino_x' => [
                [
                    [1 => ['amount' => 31, 'due' => null]],
                    [1 => ['amount' => 33, 'due' => '1999-09-09']],
                    [1 => ['amount' => 37, 'due' => null]],
                ],
                [[1 => 68], [1 => 33]],
                null,
            ],
        ];
    }

    /**
     * @return array
     */
    public function nonPerishableItemIngressDataProvider()
    {
        return [
            'prueba_01_camino_x' => [
                [
                    [1 => ['amount' => 31, 'due' => null]],
                    [1 => ['amount' => 33, 'due' => '1999-09-09']],
                    [1 => ['amount' => 37, 'due' => null]],
                ],
                [[1 => 101]],
                null,
            ],
        ];
    }

    /**
     * @return \PCI\Models\User
     */
    protected function getUser()
    {
        return $this->getGenericAdmin();
    }

    /**
     * @return void
     */
    protected function persistData()
    {
        ItemIntegrationTest::createStockTypes();
        $stock                        = StockType::whereDesc('Kilo')->first();
        $this->item                   = factory(Item::class, 'full')->create(
            ['minimum' => 60, 'stock_type_id' => $stock->id]
        );
        $this->item->type->perishable = true;
        $this->item->type->save();
        factory(NoteType::class)->create();
        factory(MovementType::class)->create(['desc' => 'Entrada']);
    }
}
