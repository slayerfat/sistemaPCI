<?php namespace Tests\PCI\Models\User\Employee\Address;

use PCI\Models\Address;
use PCI\Models\Employee;
use PCI\Models\Parish;
use Tests\AbstractTestCase;

class AddressRelationsTest extends AbstractTestCase
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
            'hasOne',
            Employee::class
        );
    }
}
