<?php namespace Tests\PCI\Repositories\User;

use Mockery;
use PCI\Models\Employee;
use PCI\Models\User;
use Tests\AbstractTestCase;
use PCI\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserRepositoryTest extends AbstractTestCase
{

    use DatabaseTransactions, DatabaseMigrations;

    /**
     * @var UserRepository
     */
    private $repo;

    /**
     * @var User
     */
    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->runDatabaseMigrations();

        $this->user = factory(User::class)->create();

        $this->repo = new UserRepository(new User);
    }

    public function testFindShouldReturnUser()
    {
        $repoResults = $this->repo->find($this->user->id);

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
        $this->actingAs($this->user);

        $repoResults = $this->repo->generateConfirmationCode();

        $this->assertInstanceOf(User::class, $repoResults);
        $this->assertSame($this->user, $repoResults);
        $this->assertNotEmpty($repoResults->confirmation_code);
    }

    public function testConfirmShouldNotPersistAndReturnFalse()
    {
        $repoResults = $this->repo->confirmCode('invalid code');

        $this->assertFalse($repoResults);
    }

    public function testConfirmShouldPersistIfCorrectCodeIsGiven()
    {
        $repoResults = $this->repo->confirmCode($this->user->confirmation_code);

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

        $user = $this->repo->update($this->user->id, $data);

        $this->assertEquals($this->user->password, $user->password);
    }

    public function testUpdateShouldChangeChangePasswordIfInputIsNotEmpty()
    {
        $data = [
            'name'       => str_random(),
            'email'      => str_random(),
            'password'   => 'password',
            'profile_id' => 1,
        ];

        $user = $this->repo->update($this->user->id, $data);

        $this->assertNotEquals($this->user->password, $user->password);
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

        $this->user->employee()->save($employee);

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
}
