<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Address;
use PCI\Models\Attendant;
use PCI\Models\Gender;
use PCI\Models\Nationality;
use PCI\Models\Note;
use PCI\Models\User;
use PCI\Models\Employee;
use PCI\Models\WorkDetail;
use Tests\AbstractPhpUnitTestCase;

class EmployeeTest extends AbstractPhpUnitTestCase
{

    public function testUser()
    {
        $this->mockBasicModelRelation(
            Employee::class,
            'user',
            'belongsTo',
            User::class
        );
    }

    public function testWorkDetails()
    {
        $this->mockBasicModelRelation(
            Employee::class,
            'workDetails',
            'hasOne',
            WorkDetail::class
        );
    }

    public function testAttendant()
    {
        $this->mockBasicModelRelation(
            Employee::class,
            'attendant',
            'hasOne',
            Attendant::class
        );
    }

    public function testNationality()
    {
        $this->mockBasicModelRelation(
            Employee::class,
            'nationality',
            'belongsTo',
            Nationality::class
        );
    }

    public function testGender()
    {
        $this->mockBasicModelRelation(
            Employee::class,
            'gender',
            'belongsTo',
            Gender::class
        );
    }

    public function testAddress()
    {
        $this->mockBasicModelRelation(
            Employee::class,
            'address',
            'belongsTo',
            Address::class
        );
    }
}
