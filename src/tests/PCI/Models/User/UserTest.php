<?php namespace Tests\PCI\Models\User;

use PCI\Models\User;
use Tests\AbstractTestCase;

class UserTest extends AbstractTestCase
{

    /**
     * @var User
     */
    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->make();
        $this->user->profile_id = User::ADMIN_ID;
        $this->user->confirmation_code = null;
    }

    public function testIsDisabledShouldNotInterfereWithIsVerifed()
    {
        $this->assertFalse($this->user->isDisabled());
        $this->assertTrue($this->user->isActive());
        $this->assertTrue($this->user->isVerified());
        $this->assertFalse($this->user->isUnverified());
    }

    public function testIsUserShouldReturnFalseWhenProfileIsAdmin()
    {
        $this->assertFalse($this->user->isUser());
    }

    public function testProfileShouldNotInterfereWithConfirmationStatus()
    {
        $this->user->profile_id = User::DISABLED_ID;

        $this->assertTrue($this->user->isDisabled());
        $this->assertFalse($this->user->isActive());
        $this->assertTrue($this->user->isVerified());
        $this->assertFalse($this->user->isUnverified());
    }

    public function testConfirmationShouldNotInterfereWithProfile()
    {
        $this->user->confirmation_code = 'null';

        $this->assertFalse($this->user->isVerified());
        $this->assertTrue($this->user->isUnverified());
        $this->assertFalse($this->user->isDisabled());
        $this->assertTrue($this->user->isActive());
    }

    public function testIsOwnerOrAdminShouldReturnTrueIfAdmin()
    {
        $this->user->id = 9000;

        $this->assertTrue($this->user->isOwnerOrAdmin(55));
    }

    public function testIsOwnerOrAdminShouldReturnFalseIfNotAdminOrIdsDontMatch()
    {
        $this->user->profile_id = User::USER_ID;
        $this->user->id = 9000;

        $this->assertFalse($this->user->isOwnerOrAdmin(9001));
        $this->asserttrue($this->user->isOwnerOrAdmin(9000));
        $this->asserttrue($this->user->isUser());
    }

    public function testIsOwnerShouldReturnFalseIfNullInput()
    {
        $this->assertFalse($this->user->isOwner(null));
    }

    public function testIsOwnerShouldReturnFalseIfNoIdIsSet()
    {
        unset($this->user->id);
        $this->assertFalse($this->user->isOwner(null));
    }
}
