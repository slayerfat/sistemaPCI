<?php namespace Tests\Integration\User;

use PCI\Models\Employee;
use PCI\Models\Parish;
use PCI\Models\State;
use PCI\Models\Town;
use PCI\Models\User;

class AddressIntegrationTest extends AbstractUserIntegration
{

    public function testShowUserWithoutEmployeeInfoCantSeeCreateAddress()
    {
        $this->actingAs($this->user)
             ->visit(route('users.show', $this->user->name))
             ->seePageIs(route('users.show', $this->user->name))
             ->dontSee(trans('models.addresses.singular'));
    }

    public function testShowUserViewHasLinkToCreateNewAddress()
    {
        $emp = factory(Employee::class)->create([
            'user_id'    => $this->user->id,
            'address_id' => null
        ]);

        $this->actingAs($this->user)
             ->visit(route('users.show', $this->user->name))
             ->see(trans('models.addresses.singular'))
             ->click(trans('models.addresses.singular'))
             ->seePageIs(route('addresses.create', $emp->id));

        // por ignorancia y falta de tiempo no se si
        // se pueda probar el ajax junto con este,
        // formulario, llega hasta aqui la prueba
    }

    public function testShowUserViewHasLinkToEditExistingAddress()
    {
        $emp = factory(Employee::class)->create([
            'user_id' => $this->user->id,
        ]);

        $this->actingAs($this->user)
             ->visit(route('users.show', $this->user->name))
             ->see(trans('models.addresses.singular'))
             ->click(trans('models.addresses.singular'))
             ->seePageIs(route('addresses.edit', $emp->id));
    }

    public function testStatesMethodShouldReturnStates()
    {
        $this->actingAs($this->user)
             ->get('api/direcciones/estados')
             ->seeJson(['id' => '1']);
    }

    public function testTownsMethodShouldReturnTownsInTheState()
    {
        $this->actingAs($this->user)
             ->get('api/direcciones/estados/1/municipios')
             ->seeJson([
                 'id'       => '1',
                 'state_id' => '1'
             ]);
    }

    public function testTownMethodShouldReturnTownsWithSameStateId()
    {
        factory(Town::class)->create([
            'state_id' => 1
        ]);
        $this->actingAs($this->user)
             ->get('api/direcciones/municipios/1')
             ->seeJson([
                 'id'       => '1',
                 'state_id' => '1'
             ])
             ->seeJson([
                 'id'       => '2',
                 'state_id' => '1'
             ]);
    }

    public function testParishesMethodShouldReturnParishesInTheTown()
    {
        $this->actingAs($this->user)
             ->get('api/direcciones/municipios/1/parroquias')
             ->seeJson([
                 'id'      => '1',
                 'town_id' => '1'
             ]);
    }

    public function testParishMethodShouldReturnParishesWithSameTownId()
    {
        factory(Parish::class)->create([
            'town_id' => 1
        ]);
        $this->actingAs($this->user)
             ->get('api/direcciones/parroquias/1')
             ->seeJson([
                 'id'      => '1',
                 'town_id' => '1'
             ])
             ->seeJson([
                 'id'      => '2',
                 'town_id' => '1'
             ]);
    }

    /**
     * @return \PCI\Models\User
     */
    protected function getUser()
    {
        return factory(User::class)->create([
            'profile_id'        => User::ADMIN_ID,
            'confirmation_code' => null
        ]);
    }

    /**
     * @return void
     */
    protected function persistData()
    {
        // Para crear una direccion necesitamos:
        // estado municiio y parroquia
        factory(State::class)->create();
        factory(Town::class)->create([
            'state_id' => 1
        ]);
        factory(Parish::class)->create([
            'town_id' => 1
        ]);
    }
}
