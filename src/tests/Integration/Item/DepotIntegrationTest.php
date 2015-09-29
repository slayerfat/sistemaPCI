<?php namespace Tests\Integration\Item;

/**
 * Por ahora extendemos AbstractUserIntegration,
 * porque no tenemos la necesidad en este momento de
 * crear otra clase especifica para Items y sus pruebas.
 * Considerando cambiar nombre de la clase de
 * AbstractUserIntegration -> AbstractGeneralIntegration o algo similar.
 */
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
             ->seePageIs(route('depots.show', 1))
             ->see(trans('models.depots.singular') . ' 1');
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
        // TODO: Implement persistData() method.
    }
}
