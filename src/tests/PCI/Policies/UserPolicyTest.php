<?php namespace Tests\PCI\Policies;

use PCI\Models\User;
use Tests\AbstractTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserPolicyTest extends AbstractTestCase
{

    use DatabaseTransactions, DatabaseMigrations;

    /**
     * @var User
     */
    private $user;

    /**
     * @var User
     */
    private $resource;

    public function setUp()
    {
        parent::setUp();

        $this->runDatabaseMigrations();

        $this->user = factory(User::class)->create([
            'profile_id' => User::ADMIN_ID
        ]);

        $this->resource = factory(User::class)->create();
    }

    public function testUserCanUpdateUserIfAdmin()
    {
        $this->assertTrue($this->user->can('update', $this->resource));
    }

    public function testUserCanNotUpdateUserIfNotAdmin()
    {
        $anotherUser = factory(User::class)->create([
            'profile_id' => User::USER_ID
        ]);

        $this->assertFalse($anotherUser->can('update', $this->resource));
    }

    public function testUserCanDeleteUserIfAdmin()
    {
        $this->assertTrue($this->user->can('destroy', $this->resource));
    }
}
