<?php namespace Tests\Integration\Item;

use PCI\Events\Note\NewItemEgress;
use PCI\Listeners\Note\GenerateItemEgress;
use PCI\Mamarrachismo\Converter\interfaces\StockTypeConverterInterface;
use PCI\Models\Depot;
use PCI\Models\Item;
use PCI\Models\Note;
use PCI\Models\NoteType;
use PCI\Models\StockType;
use Tests\Integration\User\AbstractUserIntegration;
use Tests\PCI\Models\Item\ItemIntegrationTest;

/**
 * Class GenerateItemEgressTest
 *
 * @package Tests\Integration\Item
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class GenerateItemEgressTest extends AbstractUserIntegration
{

    /**
     * @var \PCI\Listeners\Note\GenerateItemEgress
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
        $this->event = new GenerateItemEgress($converter);
    }

    /**
     * @dataProvider setStockDataProvider
     * @param $depots
     * @param $request
     * @param $stock
     */
    public function testSetStock(
        $depots,
        $itemType,
        $noteType,
        $request,
        $stock
    )
    {
        $this->item->stock_type_id = $itemType;
        $this->item->save();
        /** @var Note $note */
        $note = factory(Note::class)->create(['note_type_id' => 1]);
        $note->petition->items()->attach($this->item->id, [
            'quantity'      => $request,
            'stock_type_id' => $noteType,
        ]);

        $this->makeDepots($depots, $itemType);

        $note->items()->attach($this->item->id, [
            'quantity'      => $request,
            'stock_type_id' => $noteType,
        ]);

        $note->fresh();

        $newEgress = new NewItemEgress($note);

        $this->event->handle($newEgress);

        foreach ($stock as $id => $amount) {
            if (is_null($amount)) {
                $this->notSeeInDatabase('depot_item', [
                    'depot_id' => $id,
                    'item_id' => $this->item->id,
                ]);
            } elseif (!is_null($amount)) {
                $this->seeInDatabase('depot_item', [
                    'depot_id' => $id,
                    'item_id'  => $this->item->id,
                    'quantity' => $amount,
                ]);
            }
        }
    }

    /**
     * @param $depots
     */
    private function makeDepots($depots, $itemType)
    {
        // garantizamos que no existan almacenes
        Depot::truncate();

        // se crean los depots
        foreach ($depots as $amount) {
            $depot = factory(Depot::class)->create();
            $this->item->depots()->attach($depot->id, [
                'quantity'      => $amount,
                'stock_type_id' => $itemType,
            ]);
        }
    }

    public function setStockDataProvider()
    {
        return [
            'prueba_01_camino_x' => [[3], 3, 3, 1, [1 => 2]],
            'prueba_02_camino_x' => [[1], 3, 3, 1, [1 => null]],
            'prueba_03_camino_x' => [[4], 3, 3, 2, [1 => 2]],
            'prueba_04_camino_x' => [[3], 3, 3, 2, [1 => 1]],
            'prueba_05_camino_x' => [
                [2, 1, 1],
                3,
                3,
                1,
                [1 => 1, 2 => 1, 3 => 1],
            ],
            'prueba_06_camino_x' => [
                [1, 1, 1],
                3,
                3,
                1,
                [1 => null, 2 => 1, 3 => 1],
            ],
            'prueba_07_camino_x' => [
                [1, 2, 1],
                3,
                3,
                2,
                [1 => null, 2 => 1, 3 => 1],
            ],
            'prueba_08_camino_x' => [
                [1, 1, 1],
                3,
                3,
                2,
                [1 => null, 2 => null, 3 => 1],
            ],
            'prueba_09_camino_x' => [
                [5, 3, 1],
                3,
                3,
                8,
                [1 => null, 2 => null, 3 => 1],
            ],
            'prueba_10_camino_x' => [
                [5, 10, 5],
                3,
                3,
                20,
                [1 => null, 2 => null, 3 => null],
            ],
            'prueba_11_camino_x' => [[], 3, 3, 1, [1 => null]],
            'prueba_12_camino_x' => [[5], 3, 1, 1, [1 => 5]],
            'prueba_13_camino_x' => [[5], 3, 2, 1, [1 => 4.999]],
            'prueba_14_camino_x' => [[5], 2, 3, 1, [1 => 5]],
            'prueba_15_camino_x' => [[5], 1, 3, 1, [1 => 5]],
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
        $stock      = StockType::whereDesc('Kilo')->first();
        $this->item = factory(Item::class, 'full')->create(
            ['minimum' => 60, 'stock_type_id' => $stock->id]
        );
        factory(NoteType::class)->create();
    }
}
