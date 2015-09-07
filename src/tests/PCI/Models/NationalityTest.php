<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Nationality;
use PCI\Models\Employee;
use Tests\AbstractPhpUnitTestCase;

class NationalityTest extends AbstractPhpUnitTestCase
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
