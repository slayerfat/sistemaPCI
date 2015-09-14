<?php namespace Tests\PCI\Repositories;

use Mockery;
use PCI\Models\User;
use PCI\Repositories\UserRepository;
use Tests\BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserRepositoryTest extends BaseTestCase
{

    use DatabaseTransactions;

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
        $repoResults = $this->repo->generateConfirmationCode();

        $this->assertInstanceOf(User::class, $repoResults);
        $this->assertEquals('testing', $repoResults->name);
    }
}
