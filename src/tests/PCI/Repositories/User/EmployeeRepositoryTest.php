<?php namespace Tests\PCI\Repositories\User;

use PCI\Models\Employee;
use PCI\Models\User;
use PCI\Repositories\User\EmployeeRepository;
use PCI\Repositories\User\UserRepository;
use Tests\PCI\Repositories\AbstractRepositoryTestCase;

class EmployeeRepositoryTest extends AbstractRepositoryTestCase
{

    /**
     * @var \PCI\Repositories\User\AddressRepository
     */
    protected $repo;

    /**
     * @var \PCI\Models\Employee
     */
    protected $model;

    /**
     * @var \PCI\Models\User
     */
    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->runDatabaseMigrations();

        $this->user = factory(User::class)->create();
    }

    public function testGetAllShouldNotBeEmpty()
    {
        $this->assertNotEmpty($this->repo->getAll());
    }

    public function testFindParentShouldReturnUser()
    {
        $result = $this->repo->findParent($this->model->user->id);

        $this->assertInstanceOf(User::class, $result);
    }

    public function testCreateShouldReturnUser()
    {
        $data = [
            'gender_id'     => 1,
            'user_id'       => $this->user->id,
            'first_name'    => 'test',
            'first_surname' => 'test',
            'ci'            => '11122233',
        ];

        $this->assertInstanceOf(
            User::class,
            $this->repo->create($data)
        );
    }

    public function testFindShouldReturnEmployee()
    {
        $repoResults = $this->repo->find($this->model->id);

        $this->assertInstanceOf(Employee::class, $repoResults);
    }

    public function testGetNewInstanceShouldReturnEmployee()
    {
        $repoResults = $this->repo->newInstance(['ci' => '22233344']);

        $this->assertInstanceOf(Employee::class, $repoResults);
        $this->assertEquals('22233344', $repoResults->ci);
    }

    public function testUpdateShouldReturnUser()
    {
        $data = [
            'gender_id'     => 1,
            'user_id'       => $this->user->id,
            'first_name'    => 'test',
            'first_surname' => 'test',
            'ci'            => '11122233',
        ];

        $user = $this->repo->update($this->model->id, $data);

        $this->seeInDatabase('employees', [
            'first_name'    => 'test',
            'first_surname' => 'test',
            'ci'            => '11122233',
        ]);
        $this->assertInstanceOf(User::class, $user);
    }

    public function testDeleteShouldReturnTrueWhenEverythingIsOk()
    {
        $employee = factory(Employee::class)->create();

        $this->seeInDatabase('employees', ['id' => $employee->id]);

        $this->assertTrue($this->repo->delete($employee->id));

        $this->notSeeInDatabase('employees', ['id' => $employee->id]);
    }

    /**
     * Crea el repositorio necesario para esta prueba.
     * @return \PCI\Repositories\AbstractRepository
     */
    protected function makeRepo()
    {
        return new EmployeeRepository(
            new Employee(),
            new UserRepository(new User())
        );
    }

    /**
     * Crea el modelo necesario para esta prueba.
     * @return \PCI\Models\AbstractBaseModel
     */
    protected function makeModel()
    {
        return factory(Employee::class)->create();
    }
}
