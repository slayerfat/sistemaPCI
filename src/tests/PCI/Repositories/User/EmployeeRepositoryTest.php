<?php namespace Tests\PCI\Repositories\User;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use PCI\Models\Employee;
use PCI\Models\User;
use PCI\Repositories\User\EmployeeRepository;
use PCI\Repositories\User\UserRepository;
use Tests\AbstractTestCase;

class EmployeeRepositoryTest extends AbstractTestCase
{

    use DatabaseTransactions, DatabaseMigrations;

    /**
     * @var \PCI\Repositories\User\AddressRepository
     */
    private $repo;

    /**
     * @var \PCI\Models\User
     */
    private $user;

    /**
     * @var \PCI\Models\Employee
     */
    private $employee;

    public function setUp()
    {
        parent::setUp();

        $this->runDatabaseMigrations();

        $this->user = factory(User::class)->create();

        $this->employee = factory(Employee::class)->create();

        $this->repo = new EmployeeRepository(
            new Employee(),
            new UserRepository(new User())
        );
    }

    public function testGetAllShouldNotBeEmpty()
    {
        $this->assertNotEmpty($this->repo->getAll());
    }

    public function testFindParentShouldReturnUser()
    {
        $result = $this->repo->findParent($this->employee->user->id);

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
        $repoResults = $this->repo->find($this->employee->id);

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

        $user = $this->repo->update($this->employee->id, $data);

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
}
