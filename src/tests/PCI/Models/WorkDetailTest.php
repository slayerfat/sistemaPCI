<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Department;
use PCI\Models\Employee;
use PCI\Models\Position;
use PCI\Models\WorkDetail;
use Tests\BaseTestCase;

class WorkDetailTest extends BaseTestCase
{

    public function testEmployee()
    {
        $this->mockBasicModelRelation(
            WorkDetail::class,
            'employee',
            'belongsTo',
            Employee::class
        );
    }

    public function testPosition()
    {
        $this->mockBasicModelRelation(
            WorkDetail::class,
            'position',
            'belongsTo',
            Position::class
        );
    }

    public function testDepartment()
    {
        $this->mockBasicModelRelation(
            WorkDetail::class,
            'department',
            'belongsTo',
            Department::class
        );
    }
}
