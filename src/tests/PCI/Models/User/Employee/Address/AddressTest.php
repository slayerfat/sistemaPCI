<?php namespace Tests\PCI\Models\User\Employee\Address;

use PCI\Models\Address;
use PCI\Models\Parish;
use PCI\Models\Employee;
use Tests\BaseTestCase;

class AddressTest extends BaseTestCase
{

    public function testParish()
    {
        $this->mockBasicModelRelation(
            Address::class,
            'parish',
            'belongsTo',
            Parish::class
        );
    }

    public function testUserDetails()
    {
        $this->mockBasicModelRelation(
            Address::class,
            'employee',
            'hasMany',
            Employee::class
        );
    }
}
