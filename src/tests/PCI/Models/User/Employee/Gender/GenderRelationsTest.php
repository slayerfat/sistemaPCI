<?php namespace Tests\PCI\Models\User\Employee\Gender;

use Mockery;
use PCI\Models\Gender;
use PCI\Models\Employee;
use Tests\AbstractTestCase;

class GenderRelationsTest extends AbstractTestCase
{

    public function testUserDetails()
    {
        $this->mockBasicModelRelation(
            Gender::class,
            'employee',
            'hasMany',
            Employee::class
        );
    }
}
