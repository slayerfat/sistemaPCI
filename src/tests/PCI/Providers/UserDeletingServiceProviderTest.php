<?php namespace Tests\PCI\Providers;

use PCI\Models\User;
use PCI\Repositories\UserRepository;
use Tests\BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserDeletingServiceProviderTest extends BaseTestCase
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

    /**
     *
     */
    public function testSystemShouldHaveAtLeastOneAdmin()
    {
        $this->markTestIncomplete();
        $this->assertTrue($this->repo->delete(1));
        $this->assertTrue($this->repo->delete(2));
    }
}
