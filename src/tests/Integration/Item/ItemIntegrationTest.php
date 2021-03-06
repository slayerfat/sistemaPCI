<?php namespace Tests\Integration\Item;

/**
 * Por ahora extendemos AbstractUserIntegration,
 * porque no tenemos la necesidad en este momento de
 * crear otra clase especifica para Items y sus pruebas.
 * Considerando cambiar nombre de la clase de
 * AbstractUserIntegration -> AbstractGeneralIntegration o algo similar.
 */
use PCI\Models\Depot;
use PCI\Models\Item;
use PCI\Models\ItemType;
use PCI\Models\Maker;
use PCI\Models\Stock;
use PCI\Models\StockDetail;
use PCI\Models\StockType;
use PCI\Models\SubCategory;
use Tests\Integration\User\AbstractUserIntegration;
use Tests\PCI\Models\Item\ItemIntegrationTest as ItemModelTest;

/**
 * Class ItemIntegrationTest
 *
 * @package Tests\Integration\Item
 *          Nice copypasta. - bill machine learning gates.
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class ItemIntegrationTest extends AbstractUserIntegration
{

    public function testShowItemDisplaysCorrectInfo()
    {
        $item = factory(Item::class, 'full')->create(['minimum' => 60]);

        $stock = factory(Stock::class)->create([
            'item_id'       => $item->id,
            'stock_type_id' => 1,
        ]);

        for ($i = 0; $i < 3; $i++) {
            $stockDetails           = new StockDetail;
            $stockDetails->quantity = 234;
            $stockDetails->stock_id = $stock->id;
            $stockDetails->save();
        }

        $this->actingAs($this->user)
            ->visit(route('items.show', $item->id))
            ->seePageIs(route('items.show', $item->id))
            ->see('702')// 234 * 3 eh
            ->see($item->desc);
    }

    public function testShowItemDisplaysCorrectStockTypesAndAmounts()
    {
        $item = factory(Item::class, 'full')->create([
            'minimum'       => 60,
            'stock_type_id' => 3,
        ]);

        foreach (range(2, 4) as $id) {
            $stock = factory(Stock::class)->create([
                'item_id'       => $item->id,
                'stock_type_id' => $id,
            ]);

            $stockDetails           = new StockDetail;
            $stockDetails->quantity = 1;
            $stockDetails->stock_id = $stock->id;
            $stockDetails->save();
        }

        $this->actingAs($this->user)
            ->visit(route('items.show', $item->id))
            ->seePageIs(route('items.show', $item->id))
            ->see('1 Gramo')
            ->see('1 Kilo')
            ->see('1 Tonelada')
            ->see('1001.001 Kilos')
            ->see($item->desc);
    }

    public function testShowDepotDisplaysCorrectStockTypesAndAmounts()
    {
        $item = factory(Item::class, 'full')->create([
            'minimum'       => 60,
            'stock_type_id' => 3,
        ]);

        $depot = factory(Depot::class)->create();

        foreach (range(2, 4) as $id) {
            $stock = factory(Stock::class)->create([
                'depot_id' => $depot->id,
                'item_id'  => $item->id,
                'stock_type_id' => $id,
            ]);

            $stockDetails           = new StockDetail;
            $stockDetails->quantity = 1;
            $stockDetails->stock_id = $stock->id;
            $stockDetails->save();
        }

        $this->actingAs($this->user)
            ->visit(route('depots.show', $depot->id))
            ->seePageIs(route('depots.show', $depot->id))
            ->see('1 Gramo')
            ->see('1 Kilo')
            ->see('1 Tonelada')
            ->see($item->desc);

        $this->actingAs($this->user)
            ->visit(route('items.index', $depot->id))
            ->seePageIs(route('items.index', $depot->id))
            ->see('1001.001 Kilos')
            ->see($item->desc);
    }

    public function testCanSeeAndVisitItemsIndex()
    {
        $this->actingAs($this->user)
            ->visit(route('index'))
            ->see(trans('models.items.plural'))
            ->visit(route('items.index'))
            ->seePageIs(route('items.index'))
            ->see(trans('models.items.plural'))
            ->see(trans('models.items.create'))
            ->click(trans('models.items.create'))
            ->seePageIs(route('items.create'));
    }

    public function testCreateItemsShouldPersistAndRedirect()
    {
        $this->actingAs($this->user)
            ->visit(route('items.create'))
            ->seePageIs(route('items.create'))
            ->select('1', 'item_type_id')
            ->select('1', 'maker_id')
            ->select('1', 'sub_category_id')
            ->select('1', 'stock_type_id')
            ->type('random item', 'desc')
            ->type('1', 'minimum')
            ->see(trans('models.items.create'))
            ->press(trans('models.items.create'))
            ->dontSee('Oops!')
            ->seePageIs(route('items.show', 2))
            ->seeInDatabase('items', [
                'item_type_id'    => 1,
                'maker_id'        => 1,
                'sub_category_id' => 1,
            ]);
    }

    public function testShowItemHasLinkToEditIt()
    {
        $this->actingAs($this->user)
            ->visit(route('items.show', 1))
            ->seePageIs(route('items.show', 1))
            ->see('Editar')
            ->see('Eliminar')
            ->click('Editar')
            ->seePageIs(route('items.edit', 1));
    }

    public function testEditItemsShouldPersistAndRedirect()
    {
        $item = factory(Item::class)->create();

        $this->actingAs($this->user)
            ->visit(route('items.edit', $item->id))
            ->seePageIs(route('items.edit', $item->id))
            ->select('1', 'item_type_id')
            ->select('1', 'maker_id')
            ->select('1', 'sub_category_id')
            ->select('1', 'stock_type_id')
            ->type('random item', 'desc')
            ->type('1', 'minimum')
            ->see(trans('models.items.edit'))
            ->press(trans('models.items.edit'))
            ->seePageIs(route('items.show', $item->id))
            ->seeInDatabase('items', [
                'item_type_id'    => 1,
                'maker_id'        => 1,
                'sub_category_id' => 1,
            ]);
    }

    public function testDeleteDepotShouldRedirectToItemsIndex()
    {
        $this->withoutMiddleware()
            ->delete(route('items.destroy', 1))
            ->assertResponseStatus(302); //302 redirect

        // softDeletes
        $this->notSeeInDatabase('items', ['id' => 1, 'deleted_at' => null]);
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
        ItemModelTest::createStockTypes();
        factory(Item::class)->create();
        factory(ItemType::class, 2)->create();
        factory(Maker::class, 2)->create();
        factory(SubCategory::class, 4)->create();
        factory(StockType::class, 4)->create();
    }
}
