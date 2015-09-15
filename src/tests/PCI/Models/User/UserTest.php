<?php namespace Tests\PCI\Models\User;

use PCI\Models\User;
use Tests\BaseTestCase;

class UserTest extends BaseTestCase
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
}
