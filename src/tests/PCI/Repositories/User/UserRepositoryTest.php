<?php namespace Tests\PCI\Repositories\User;

use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use PCI\Models\Employee;
use PCI\Models\User;
use PCI\Repositories\User\UserRepository;
use Tests\PCI\Repositories\AbstractRepositoryTestCase;

class UserRepositoryTest extends AbstractRepositoryTestCase
{

    /**
     * @var \PCI\Repositories\User\UserRepository
     */
    protected $repo;

    /**
     * @var \PCI\Models\User
     */
    protected $model;

    public function testFindShouldReturnUser()
    {
        $repoResults = $this->repo->find($this->model->id);

        $this->assertInstanceOf(User::class, $repoResults);
    }

    public function testGetNewInstanceShouldReturnUser()
    {
        $repoResults = $this->repo->newInstance(['name' => 'testing']);

        $this->assertInstanceOf(User::class, $repoResults);
        $this->assertEquals('testing', $repoResults->name);
    }

    public function testGenerateConfirmationCodeShouldMakeChangesAndReturnUser()
    {
        $this->actingAs($this->model);

        $repoResults = $this->repo->generateConfirmationCode();

        $this->assertInstanceOf(User::class, $repoResults);
        $this->assertSame($this->model, $repoResults);
        $this->assertNotEmpty($repoResults->confirmation_code);
    }

    public function testConfirmShouldNotPersistAndReturnFalse()
    {
        $repoResults = $this->repo->confirmCode('invalid code');

        $this->assertFalse($repoResults);
    }

    public function testConfirmShouldPersistIfCorrectCodeIsGiven()
    {
        $repoResults = $this->repo->confirmCode($this->model->confirmation_code);

        $this->assertTrue($repoResults);
    }

    public function testGetAllShouldNotBeEmpty()
    {
        $this->assertNotEmpty($this->repo->getAll());
    }


    public function testUpdateShouldNotChangePasswordIfInputIsEmpty()
    {
        $data = [
            'name'       => str_random(),
            'email'      => str_random(),
            'password'   => '',
            'profile_id' => 1,
        ];

        $user = $this->repo->update($this->model->id, $data);

        $this->assertEquals($this->model->password, $user->password);
    }

    public function testUpdateShouldChangeChangePasswordIfInputIsNotEmpty()
    {
        $data = [
            'name'       => str_random(),
            'email'      => str_random(),
            'password'   => 'password',
            'profile_id' => 1,
        ];

        $user = $this->repo->update($this->model->id, $data);

        $this->assertNotEquals($this->model->password, $user->password);
    }

    public function testCreateShouldReturnUser()
    {
        $data = [
            'name'       => str_random(),
            'email'      => str_random(),
            'password'   => 'password',
            'profile_id' => 1,
        ];

        $this->assertInstanceOf(
            User::class,
            $this->repo->create($data)
        );
    }

    public function testGetAllForTableWithPaginator()
    {
        $this->assertInstanceOf(
            LengthAwarePaginator::class,
            $this->repo->getTablePaginator()
        );
    }

    public function testPaginatorShouldReturnEmplyeeDayaIfUserHas()
    {
        $employee = factory(Employee::class)->make();

        $this->model->employee()->save($employee);

        $results = $this->repo->getTablePaginator();

        $this->assertFalse($results->isEmpty());
        $this->assertArrayHasKey('Nombres', $results->getCollection()->first());
    }

    public function testDeleteShouldReturnBooleanWhenEverythingIsOk()
    {
        $user = factory(User::class)->create();

        $this->assertTrue($this->repo->delete($user->id));
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function testDeleteShouldThrowExceptionWhenNullGiven()
    {
        $this->assertTrue($this->repo->delete(null));
    }

    /**
     * Crea el repositorio necesario para esta prueba.
     * @return \PCI\Repositories\AbstractRepository
     */
    protected function makeRepo()
    {
        return new UserRepository(new User);
    }

    /**
     * Crea el modelo necesario para esta prueba.
     * @return \PCI\Models\AbstractBaseModel
     */
    protected function makeModel()
    {
        return factory(User::class)->create();
    }
}
