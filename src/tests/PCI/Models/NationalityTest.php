<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Nationality;
use PCI\Models\Employee;
use Tests\BaseTestCase;

class NationalityTest extends BaseTestCase
{
    public function testUserDetails()
    {
        $this->mockBasicModelRelation(
            Nationality::class,
            'employee',
            'hasMany',
            Employee::class
        );
    }
}
