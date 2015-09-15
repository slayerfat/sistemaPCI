<?php namespace Tests\PCI\Models\User;

use Mockery;
use PCI\Models\Attendant;
use PCI\Models\Note;
use PCI\Models\Petition;
use PCI\Models\Profile;
use PCI\Models\User;
use PCI\Models\Employee;
use Tests\BaseTestCase;

class UserRelationsTest extends BaseTestCase
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
}
