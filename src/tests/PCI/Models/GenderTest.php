<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Gender;
use PCI\Models\Employee;
use Tests\AbstractPhpUnitTestCase;

class GenderTest extends AbstractPhpUnitTestCase
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
