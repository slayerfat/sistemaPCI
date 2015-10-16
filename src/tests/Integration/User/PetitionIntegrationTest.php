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

    public function testIndexShouldHaveTableWIthData()
    {
        $petition = Petition::first();

        $this->actingAs($this->user)
            ->visit(route('petitions.index'))
            ->seePageIs(route('petitions.index'))
            ->see($petition->user->name)
            ->see($petition->user->email)
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

    /**
     * @return \PCI\Models\User
     */
    protected function getUser()
    {
        return factory(User::class, 'admin')->create();
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
            'quantity'      => $item->stock,
            'stock_type_id' => $item->stock_type_id,
        ]);
    }
}
