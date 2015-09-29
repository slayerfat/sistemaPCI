<?php namespace Tests\PCI\Repositories\User;

use Mockery;
use PCI\Models\Address;
use PCI\Models\Employee;
use PCI\Models\User;
use PCI\Repositories\User\AddressRepository;
use PCI\Repositories\User\EmployeeRepository;
use PCI\Repositories\User\UserRepository;
use Tests\PCI\Repositories\AbstractRepositoryTestCase;

class AddressRepositoryTest extends AbstractRepositoryTestCase
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

        $this->user = factory(User::class)->create();
    }

    public function testGetAllShouldNotBeEmpty()
    {
        $this->assertNotEmpty($this->repo->getAll());
    }

    public function testFindParentShouldReturnEmployee()
    {
        $result = $this->repo->findParent($this->model->id);

        $this->assertInstanceOf(Employee::class, $result);
    }

    public function testCreateShouldReturnUser()
    {
        $data = [
            'parish_id'   => 1,
            'av'          => 'test',
            'street'      => 'test',
            'building'    => 'test',
            'employee_id' => $this->model->id,
        ];

        $this->assertInstanceOf(
            User::class,
            $this->repo->create($data)
        );
    }

    public function testFindShouldReturnAddress()
    {
        $repoResults = $this->repo->find($this->model->address->id);

        $this->assertInstanceOf(Address::class, $repoResults);
    }

    public function testGetNewInstanceShouldReturnAddress()
    {
        $repoResults = $this->repo->newInstance(['av' => 'testing']);

        $this->assertInstanceOf(Address::class, $repoResults);
        $this->assertEquals('Testing', $repoResults->av);
    }

    public function testUpdateShouldReturnUser()
    {
        $data = [
            'parish_id'   => 1,
            'av'          => 'testing',
            'street'      => 'testing',
            'building'    => 'testing',
            'employee_id' => $this->model->id,
        ];

        $user = $this->repo->update($this->model->address->id, $data);

        $this->seeInDatabase('addresses', [
            'av'       => 'testing',
            'street'   => 'testing',
            'building' => 'testing',
        ]);
        $this->assertInstanceOf(User::class, $user);
    }

    public function testDeleteShouldReturnTrueWhenEverythingIsOk()
    {
        $address = factory(Address::class)->create();

        $this->seeInDatabase('addresses', ['id' => $address->id]);

        $this->assertTrue($this->repo->delete($address->id));

        $this->notSeeInDatabase('addresses', ['id' => $address->id]);
    }

    /**
     * Crea el repositorio necesario para esta prueba.
     * @return \PCI\Repositories\AbstractRepository
     */
    protected function makeRepo()
    {
        // debido a que el repositorio de direccion depende
        // del repositorio de empleado que tiene sus
        // dependendias, y como no queremos usar
        // el IOC container, lo hacemos
        // explicitamente aqui.
        return new AddressRepository(
            new Address(),
            new EmployeeRepository(
                new Employee(),
                new UserRepository(new User())
            )
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
