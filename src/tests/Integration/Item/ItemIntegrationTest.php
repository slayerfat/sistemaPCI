<?php namespace Tests\Integration\Item;

/**
 * Por ahora extendemos AbstractUserIntegration,
 * porque no tenemos la necesidad en este momento de
 * crear otra clase especifica para Items y sus pruebas.
 * Considerando cambiar nombre de la clase de
 * AbstractUserIntegration -> AbstractGeneralIntegration o algo similar.
 */
use PCI\Models\Item;
use PCI\Models\ItemType;
use PCI\Models\Maker;
use PCI\Models\SubCategory;
use PCI\Models\User;
use Tests\Integration\User\AbstractUserIntegration;

/**
 * Class ItemIntegrationTest
 * @package Tests\Integration\Item
 * Nice copypasta. - bill machine learning gates.
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class ItemIntegrationTest extends AbstractUserIntegration
{

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
             ->type('random item', 'desc')
             ->type('1', 'stock')
             ->type('1', 'minimum')
             ->see(trans('models.items.create'))
             ->press(trans('models.items.create'))
             ->dontSee('Oops!')
             ->seePageIs(route('items.show', 2))
             ->seeInDatabase('items', [
                 'item_type_id'    => 1,
                 'maker_id'        => 1,
                 'sub_category_id' => 1
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
             ->type('random item', 'desc')
             ->type('1', 'stock')
             ->type('1', 'minimum')
             ->see(trans('models.items.edit'))
             ->press(trans('models.items.edit'))
             ->seePageIs(route('items.show', $item->id))
             ->seeInDatabase('items', [
                 'item_type_id'    => 1,
                 'maker_id'        => 1,
                 'sub_category_id' => 1
             ]);
    }

    public function testDeleteDepotShouldRedirectToItemsIndex()
    {
        $this->withoutMiddleware()
             ->delete(route('items.destroy', 1))
             ->assertResponseStatus(302); //302 redirect

        $this->notSeeInDatabase('items', ['id' => 1]);
    }

    /**
     * @return \PCI\Models\User
     */
    protected function getUser()
    {
        return factory(User::class)->create([
            'profile_id'        => User::ADMIN_ID,
            'confirmation_code' => null,
        ]);
    }

    /**
     * @return void
     */
    protected function persistData()
    {
        factory(Item::class)->create();
        factory(ItemType::class, 2)->create();
        factory(Maker::class, 2)->create();
        factory(SubCategory::class, 4)->create();
    }
}
