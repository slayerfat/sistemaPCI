<?php namespace Tests\Integration\Item;

/**
 * Por ahora extendemos AbstractUserIntegration,
 * porque no tenemos la necesidad en este momento de
 * crear otra clase especifica para Items y sus pruebas.
 * Considerando cambiar nombre de la clase de
 * AbstractUserIntegration -> AbstractGeneralIntegration o algo similar.
 */
use PCI\Models\Depot;
use PCI\Models\User;
use Tests\Integration\User\AbstractUserIntegration;

/**
 * Class DepotIntegrationTest
 * @package Tests\Integration\Item
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class DepotIntegrationTest extends AbstractUserIntegration
{

    public function testDepotNumberCantBeCero()
    {
        $this->actingAs($this->user)
             ->visit(route('depots.create'))
             ->seePageIs(route('depots.create'))
             ->select('1', 'number')
             ->type('515', 'shelf')
             ->type('25255', 'rack')
             ->see(trans('models.depots.create'))
             ->press(trans('models.depots.create'))
            ->seePageIs(route('depots.show', 2))
             ->see(trans('models.depots.singular') . ' 1');
    }

    public function testCanSeeAndVisitDepotsIndex()
    {
        $this->actingAs($this->user)
             ->visit(route('home'))
             ->seePageIs(route('index'))
             ->see(trans('models.depots.plural'))
             ->visit(route('depots.index'))
             ->seePageIs(route('depots.index'))
             ->see(trans('models.depots.create'))
             ->click(trans('models.depots.create'))
             ->seePageIs(route('depots.create'));
    }

    public function testShowDepotsHasLinks()
    {
        $this->actingAs($this->user)
             ->visit(route('depots.show', 1))
             ->seePageIs(route('depots.show', 1))
             ->see(trans('models.depots.singular') . ' 1')
             ->see('Editar')
             ->see('Eliminar')
             ->click('Editar')
             ->seePageIs(route('depots.edit', 1));
    }

    public function testEditDepotsShouldPersistAndRedirect()
    {
        $this->actingAs($this->user)
             ->visit(route('depots.edit', 1))
             ->seePageIs(route('depots.edit', 1))
             ->select('2', 'number')
             ->type('3', 'shelf')
             ->type('4', 'rack')
             ->see(trans('models.depots.edit'))
             ->press(trans('models.depots.edit'))
             ->seePageIs(route('depots.show', 1))
             ->see(trans('models.depots.singular') . ' 2')
             ->seeInDatabase('depots', [
                 'number' => 2,
                 'rack'   => 4,
                 'shelf'  => 3
             ]);
    }

    public function testDeleteDepotShouldRedirectToDepotsIndex()
    {
        $this->withoutMiddleware()
             ->delete(route('depots.destroy', 1))
             ->assertResponseStatus(302); //302 redirect

        $this->notSeeInDatabase('depots', ['id' => 1]);
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
        factory(Depot::class)->create(['number' => 1]);
    }
}
