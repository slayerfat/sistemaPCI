<?php namespace Tests\Integration\User;

use PCI\Models\Employee;
use PCI\Models\Gender;
use PCI\Models\Nationality;
use PCI\Models\User;

class EmployeeIntegrationTest extends AbstractUserIntegration
{

    public function setUp()
    {
        parent::setUp();

        $this->user = $this->getUser();

        $this->persistData();
    }

    /**
     * @return \PCI\Models\User
     */
    protected function getUser()
    {
        /** @var \PCI\Models\User $user */
        $user             = User::first();
        $user->profile_id = User::ADMIN_ID;
        $user->save();

        return $user;
    }

    /**
     * @return void
     */
    protected function persistData()
    {
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
            ->see(trans('models.employees.store.success'))
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

    public function testUserShouldBeAbleToEditIfAdmin()
    {
        $randomUser = factory(User::class)->create();
        $employee   = factory(Employee::class)->create(['user_id' => $randomUser->id]);

        $this->actingAs($this->user)
            ->visit(route('users.show', $randomUser->name))
            ->seePageIs(route('users.show', $randomUser->name))
            ->see(trans('models.employees.singular'))
            ->click(trans('models.employees.singular'))
            ->seePageIs(route('employees.edit', $employee->id))
            ->type('testing', 'first_name')
            ->type('again', 'first_surname')
            ->press(trans('models.employees.edit'))
            ->seePageIs(route('users.show', $randomUser->name))
            ->see(trans('models.employees.update.success'))
            ->see('testing')
            ->see('again');
    }

    public function testNonAdminShouldntBeAbleToEditEmployee()
    {
        $anotherUser = factory(User::class)->create(['confirmation_code' => null]);

        $randomUser = factory(User::class)->create();
        $employee   = factory(Employee::class)->create(['user_id' => $randomUser->id]);

        $this->actingAs($anotherUser)
            ->visit(route('index'))
            ->seePageIs(route('index'))
            ->visit(route('employees.edit', $employee->id))
            ->see(trans('defaults.auth.error'))
            ->seePageIs(route('index'));
    }
}
