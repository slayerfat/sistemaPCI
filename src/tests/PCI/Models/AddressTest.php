<?php namespace Tests\PCI\Models;

use PCI\Models\Address;
use PCI\Models\Parish;
use PCI\Models\Employee;
use Tests\AbstractPhpUnitTestCase;

class AddressTest extends AbstractPhpUnitTestCase
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
