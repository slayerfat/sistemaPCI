<?php namespace Tests\PCI\Models\User\Employee\Nationality;

use Mockery;
use PCI\Models\Nationality;
use PCI\Models\Employee;
use Tests\BaseTestCase;

class NationalityRelationsTest extends BaseTestCase
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
