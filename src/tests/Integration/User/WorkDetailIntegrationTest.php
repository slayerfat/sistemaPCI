<?php namespace Tests\Integration\User;

use PCI\Models\Department;
use PCI\Models\Employee;
use PCI\Models\Position;
use PCI\Models\User;
use PCI\Models\WorkDetail;

class WorkDetailIntegrationTest extends AbstractUserIntegration
{

    public function testSideBarMenuShouldNotHaveCreateLinks()
    {
        $this->actingAs($this->user)
             ->visit(route('users.show', $this->user->name))
             ->seePageIs(route('users.show', $this->user->name))
             ->dontSee(trans('models.workDetails.singular'));
    }

    public function testSideBarMenuShouldHaveCreateLinks()
    {
        $employee = factory(Employee::class)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user)
             ->visit(route('users.show', $this->user->name))
             ->seePageIs(route('users.show', $this->user->name))
             ->see(trans('models.workDetails.singular'))
             ->click(trans('models.workDetails.singular'))
             ->seePageIs(route('workDetails.create', $employee->id));
    }

    public function testUserCanCreateIfAdminAndNoEmployee()
    {
        $employee = factory(Employee::class)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user)
             ->visit(route('workDetails.create', $employee->id))
             ->seePageIs(route('workDetails.create', $employee->id))
             ->see(trans('models.workDetails.create'))
             ->type('1999-08-07', 'join_date')
             ->type('2001-02-03', 'departure_date')
             ->select('1', 'department_id')
             ->select('1', 'position_id')
             ->press(trans('models.workDetails.create'))
             ->dontSee(trans('defaults.auth.error'))
             ->dontSee('Oops!')
             ->see(trans('models.workDetails.store.success'))
             ->seePageIs(route('users.show', $this->user->name));
    }

    public function testUserShouldNotcreateIfNotAdmin()
    {
        $user = factory(User::class)->create(['confirmation_code' => null]);
        $employee = factory(Employee::class)->create(['user_id' => $this->user->id]);

        $this->actingAs($user)
             ->visit(route('index'))
             ->seePageIs(route('index'))
             ->visit(route('workDetails.create', $employee->id))
             ->see(trans('defaults.auth.error'))
             ->seePageIs(route('index'));
    }

    public function testUserShouldNotcreateIfAlreadyWoekDetailsModel()
    {
        $randomUser                    = factory(User::class)->create();
        $workDetail                    = factory(WorkDetail::class)->create();
        $workDetail->employee->user_id = $randomUser->id;
        $workDetail->employee->save();

        $this->actingAs($this->user)
             ->visit(route('index'))
             ->seePageIs(route('index'))
            ->visit(route('workDetails.create', $workDetail->employee->id))
             ->see(trans('defaults.auth.error'))
             ->seePageIs(route('index'));
    }

    public function testUserShouldBeAbleToEditIfAdmin()
    {
        $randomUser = factory(User::class)->create();
        $workDetail                    = factory(WorkDetail::class)->create();
        $workDetail->employee->user_id = $randomUser->id;
        $workDetail->employee->save();

        $this->actingAs($this->user)
             ->visit(route('users.show', $randomUser->name))
             ->seePageIs(route('users.show', $randomUser->name))
             ->see(trans('models.workDetails.singular'))
             ->click(trans('models.workDetails.singular'))
             ->seePageIs(route('workDetails.edit', $workDetail->id))
             ->type('1999-08-07', 'join_date')
             ->type('2001-02-03', 'departure_date')
             ->select('1', 'department_id')
             ->select('1', 'position_id')
             ->press(trans('models.workDetails.edit'))
             ->dontSee('Oops!')
             ->seePageIs(route('users.show', $randomUser->name))
             ->see(trans('models.workDetails.update.success'));
    }

    public function testNonAdminShouldntBeAbleToEditEmployee()
    {
        $anotherUser = factory(User::class)->create(['confirmation_code' => null]);
        $workDetail = factory(WorkDetail::class)->create();

        $this->actingAs($anotherUser)
             ->visit(route('index'))
             ->seePageIs(route('index'))
             ->visit(route('workDetails.edit', $workDetail->id))
             ->see(trans('defaults.auth.error'))
             ->seePageIs(route('index'));
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
        factory(Department::class, 2)->create();

        // tambien necesitamos nacionalidades para crear y actualizar
        factory(Position::class, 2)->create();
    }
}
