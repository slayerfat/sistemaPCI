<?php namespace Tests\Integration\User;

use PCI\Models\Employee;
use PCI\Models\Gender;
use PCI\Models\Nationality;
use PCI\Models\User;
use Tests\Integration\AbstractIntegrationTest;

class EmployeeIntegrationTest extends AbstractIntegrationTest
{

    /**
     * @var \PCI\Models\User
     */
    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->user             = User::first();
        $this->user->profile_id = User::ADMIN_ID;
        $this->user->save();

        // necesitamos generos para crear y actualizar
        factory(Gender::class, 2)->create();

        // tambien necesitamos nacionalidades para crear y actualizar
        factory(Nationality::class, 2)->create();
    }

    public function testSideBarMenuShouldHaveCreateLinks()
    {
        $this->actingAs($this->user)
            ->visit(route('users.show', $this->user->name))
            ->seePageIs(route('users.show', $this->user->name))
            ->see(trans('models.employees.singular'))
            ->click(trans('models.employees.singular'))
            ->seePageIs(route('employees.create', $this->user->name));
    }

    public function testUserCanCreateIfAdminAndNoEmployee()
    {
        $this->actingAs($this->user)
            ->visit(route('employees.create', $this->user->name))
            ->seePageIs(route('employees.create', $this->user->name))
            ->see(trans('models.employees.create'))
            ->type('testing', 'first_name')
            ->type('again', 'first_surname')
            ->select('1', 'gender_id')
            ->press(trans('models.employees.create'))
            ->dontSee(trans('defaults.auth.error'))
            ->dontSee('Oops!')
            ->seePageIs(route('users.show', $this->user->name));
    }

    public function testUserShouldNotcreateIfNotAdmin()
    {
        $user = factory(User::class)->create(['confirmation_code' => null]);

        $this->actingAs($user)
            ->visit(route('index'))
            ->seePageIs(route('index'))
            ->visit(route('employees.create', $this->user->name))
            ->see(trans('defaults.auth.error'))
            ->seePageIs(route('index'));
    }

    public function testUserShouldNotcreateIfAlreadyEmployeeModel()
    {
        factory(Employee::class)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user)
            ->visit(route('index'))
            ->seePageIs(route('index'))
            ->visit(route('employees.create', $this->user->name))
            ->see(trans('defaults.auth.error'))
            ->seePageIs(route('index'));
    }
}
