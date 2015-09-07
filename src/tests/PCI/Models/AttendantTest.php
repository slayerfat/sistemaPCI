<?php namespace Tests\PCI\Models;

use PCI\Models\Attendant;
use PCI\Models\Employee;
use Tests\AbstractPhpUnitTestCase;

class AttendantTest extends AbstractPhpUnitTestCase
{

    public function testEmployee()
    {
        $this->mockBasicModelRelation(
            Attendant::class,
            'employee',
            'belongsTo',
            Employee::class
        );
    }
}
