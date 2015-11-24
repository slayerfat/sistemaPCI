<?php namespace Tests\Integration\User;

/**
 * Por ahora extendemos AbstractUserIntegration,
 * porque no tenemos la necesidad en este momento de
 * crear otra clase especifica para Items y sus pruebas.
 * Considerando cambiar nombre de la clase de
 * AbstractUserIntegration -> AbstractGeneralIntegration o algo similar.
 */

use PCI\Models\Item;
use PCI\Models\Petition;
use PCI\Models\User;

/**
 * Class PetitionIntegrationTest
 *
 * @package Tests\Integration\Item
 *          Nice copypasta. - bill 'machine learning' gates.
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class PetitionIntegrationTest extends AbstractUserIntegration
{

    /**
     * @var Petition[]|\Illuminate\Support\Collection
     */
    public $petition;

    public function testIndexShouldHaveTableWIthData()
    {
        $petition = Petition::first();

        $this->actingAs($this->user)
            ->visit(route('petitions.index'))
            ->seePageIs(route('petitions.index'))
            ->see($petition->user->name)
            ->see($petition->formattedStatus)
            ->see(trans('models.petitions.create'))
            ->see(trans('models.petitions.plural'));
    }

    public function testShowPetitionShouldHaveData()
    {
        $petition = Petition::first();

        $this->actingAs($this->user)
            ->visit(route('petitions.show', $petition->id))
            ->seePageIs(route('petitions.show', $petition->id))
            ->see($petition->user->name)
            ->see($petition->formattedStatus)
            ->see($petition->items->first()->desc)
            ->see(trans('models.petitions.singular'));
    }

    public function testShowPetitionShouldLinkToAssociatedItems()
    {
        $petition = Petition::first();

        $this->actingAs($this->user)
            ->visit(route('petitions.show', $petition->id))
            ->seePageIs(route('petitions.show', $petition->id))
            ->see($petition->items->first()->desc)
            ->see(route('items.show', $petition->items->first()->id))
            ->click("model-show-{$petition->items->first()->id}")
            ->seePageIs(route('items.show', $petition->items->first()->id))
            ->see($petition->items->first()->desc);
    }

    public function testPetitionCreateShowsForm()
    {
        $this->actingAs($this->user)
            ->visit(route('petitions.index'))
            ->click(trans('models.petitions.create'))
            ->seePageIs(route('petitions.create'));
    }

    public function testIndexReturnsCorrectAmountIfAdmin()
    {
        foreach (range(1, 5) as $index) {
            $this->petition[] = factory(Petition::class)
                ->create(['comments' => "mocked_[$index]"]);
        }

        foreach ($this->petition as $petition) {
            $this->actingAs($this->user)
                ->visit(route('petitions.index'))
                ->see($petition->user->name);
        }
    }

    public function testIndexReturnsCeroNotesIfNotAdmin()
    {
        $user = factory(User::class, 'user')->create();
        foreach (range(1, 5) as $index) {
            $this->petition[] = factory(Petition::class)
                ->create(['comments' => "mocked_[$index]"]);
        }

        foreach ($this->petition as $petition) {
            $this->actingAs($user)
                ->visit(route('petitions.index'))
                ->dontSee($petition->user->email);
        }
    }

    public function testPetitionCantCreateWithoutItems()
    {
        $this->actingAs($this->user)
            ->visit(route('petitions.create'))
            ->seePageIs(route('petitions.create'))
            ->see(trans('models.petitions.create'))
            ->press(trans('models.petitions.create'))
            ->see('Oops!');
    }

    public function testPetitionShowsEditForm()
    {
        $petition = factory(Petition::class)->create(['status' => null]);
        $item     = factory(Item::class, 'full')->create();
        $petition->items()->attach($item->id, [
            'quantity'      => $item->stock(),
            'stock_type_id' => $item->stock_type_id,
        ]);

        $this->actingAs($this->user)
            ->visit(route('petitions.edit', $petition->id))
            ->seePageIs(route('petitions.edit', $petition->id))
            ->see(trans('models.petitions.edit'));
    }

    public function testPetitionCantEditIfStatusIsNotNull()
    {
        $petition = factory(Petition::class)->create(['status' => true]);

        $this->actingAs($this->user)
            ->visit(route('petitions.edit', $petition->id))
            ->see('Los Pedidos solo pueden ser editados si est&aacute;n por aprobar.');
    }

    public function testPetitionShowViewShowEditDeleteButtonsIfStatusIsNull()
    {
        $petition = factory(Petition::class)->create(['status' => null]);

        $this->actingAs($this->user)
            ->visit(route('petitions.show', $petition->id))
            ->seePageIs(route('petitions.show', $petition->id))
            ->seeLink("Solicitar Aprobación")
            ->see("model-edit-{$petition->id}")
            ->see("model-delete-{$petition->id}");
    }

    public function testPetitionShowViewDoesNotShowEditDeleteButtons()
    {
        $petition = factory(Petition::class)->create(['status' => true]);

        $this->actingAs($this->user)
            ->visit(route('petitions.show', $petition->id))
            ->seePageIs(route('petitions.show', $petition->id))
            ->dontSeeLink("Solicitar Aprobación")
            ->dontSee("model-edit-{$petition->id}")
            ->dontSee("model-delete-{$petition->id}");
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
        factory(Petition::class, 5)->create();

        $petition = Petition::first();
        $item     = factory(Item::class, 'full')->create();
        $petition->items()->attach($item->id, [
            'quantity'      => $item->stock(),
            'stock_type_id' => $item->stock_type_id,
        ]);
    }
}
