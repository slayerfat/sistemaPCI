<?php namespace Tests\PCI\Providers;

use DB;
use PCI\Models\User;
use Tests\AbstractTestCase;
use PCI\Repositories\User\UserRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserDeletingServiceProviderTest extends AbstractTestCase
{

    use DatabaseTransactions, DatabaseMigrations;

    /**
     * @var \PCI\Repositories\User\UserRepository
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
     * @expectedException \PCI\Providers\Exceptions\AdminCountException
     */
    public function testSystemShouldHaveAtLeastOneAdmin()
    {
        $this->user->destroy(1);
    }

    /**
     * @expectedException \PCI\Providers\Exceptions\AdminCountException
     */
    public function testGetAdminIdShoudThrowExceptionWhenNoAdminFound()
    {
        // lo hago de esta forma para obviar cualquier guardia en la aplicacion.
        DB::raw("UPDATE users set users.profile_id = 2 WHERE users.id = 1");

        $this->user->destroy(1);
    }

    public function testCanDeleteIfMoreThanOneAdmin()
    {
        $user = factory(User::class)->create(['profile_id' => User::ADMIN_ID]);

        $this->user->destroy($user->id);
    }

    public function testAttributeChangeWhenUserHasSameId()
    {
        $edited = factory(User::class)->create(['profile_id' => User::USER_ID]);
        $edited->created_by = $edited->id;
        $edited->updated_by = $edited->id;
        $edited->save();

        $this->user->destroy($edited->id);
    }

    public function testUserProfilesShouldntMatter()
    {
        $userOne = factory(User::class)->create(['profile_id' => User::USER_ID]);
        $userTwo = factory(User::class)->create(['profile_id' => User::DISABLED_ID]);

        $this->user->destroy([$userOne->id, $userTwo->id]);
    }
}
