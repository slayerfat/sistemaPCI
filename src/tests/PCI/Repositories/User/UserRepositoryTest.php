<?php namespace Tests\PCI\Repositories;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mockery;
use PCI\Models\User;
use Tests\BaseTestCase;
use PCI\Repositories\UserRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserRepositoryTest extends BaseTestCase
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
        $repoResults = $this->repo->getNewInstance(['name' => 'testing']);

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
        $repoResults = $this->repo->confirm('invalid code');

        $this->assertFalse($repoResults);
    }

    public function testConfirmShouldPersistIfCorrectCodeIsGiven()
    {
        $repoResults = $this->repo->confirm($this->user->confirmation_code);

        $this->assertTrue($repoResults);
    }

    public function testGetAllShouldNotBeEmpty()
    {
        $this->assertNotEmpty($this->repo->getAll());
    }


    public function testUpdateShouldNotChangePasswordIfInputIsEmpty()
    {
        $data = [
            'name'       => 'tester',
            'email'      => 'tester@test.com',
            'password'   => '',
            'profile_id' => 1,
        ];

        $user = $this->repo->update($this->user->id, $data);

        $this->assertEquals($this->user->password, $user->password);
    }

    public function testUpdateShouldChangeChangePasswordIfInputIsNotEmpty()
    {
        $data = [
            'name'       => 'tester',
            'email'      => 'tester@test.com',
            'password'   => 'password',
            'profile_id' => 1,
        ];

        $user = $this->repo->update($this->user->id, $data);

        $this->assertNotEquals($this->user->password, $user->password);
    }
}
