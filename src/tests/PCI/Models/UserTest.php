<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Attendant;
use PCI\Models\Note;
use PCI\Models\Petition;
use PCI\Models\Profile;
use PCI\Models\User;
use PCI\Models\Employee;
use Tests\BaseTestCase;

class UserTest extends BaseTestCase
{

    public function testDetails()
    {
        $this->mockBasicModelRelation(
            User::class,
            'employee',
            'hasOne',
            Employee::class
        );
    }

    public function testProfile()
    {
        $this->mockBasicModelRelation(
            User::class,
            'profile',
            'belongsTo',
            Profile::class
        );
    }

    public function testAttendant()
    {
        $this->mockBasicModelRelation(
            User::class,
            'attendant',
            'hasOne',
            Attendant::class
        );
    }

    public function testNotes()
    {
        $this->mockBasicModelRelation(
            User::class,
            'notes',
            'hasMany',
            Note::class
        );
    }

    public function testPetitions()
    {
        $this->mockBasicModelRelation(
            User::class,
            'petitions',
            'hasMany',
            Petition::class
        );
    }

    public function testIsDisabledShouldReturnFalseIfProfileIsNotDisbled()
    {
        $user = factory(User::class)->make();
        $user->profile_id = User::ADMIN_ID;
        $user->confirmation_code = null;

        $this->assertFalse($user->isDisabled());
        $this->assertTrue($user->isActive());
    }

    public function testIsVerifiedShouldReturnFalseIfUserIsNotVerified()
    {
        $user = factory(User::class)->make();
        $user->profile_id = User::ADMIN_ID;
        $user->confirmation_code = 'null';

        $this->assertFalse($user->isVerified());
        $this->assertTrue($user->isUnverified());
    }

    public function testIsVerifiedShouldReturnTrueIfUserIsVerified()
    {
        /** @var User $user */
        $user = factory(User::class)->make();
        $user->profile_id = User::ADMIN_ID;
        $user->confirmation_code = null;

        $this->assertTrue($user->isVerified());
        $this->assertFalse($user->isUnverified());
    }
}
