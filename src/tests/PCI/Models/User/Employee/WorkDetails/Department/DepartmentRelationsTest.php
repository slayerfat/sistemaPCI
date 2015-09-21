<?php namespace Tests\PCI\Models\User\Employee\WorkDetails\Department;

use Mockery;
use PCI\Models\Department;
use PCI\Models\WorkDetail;
use Tests\AbstractTestCase;

class DepartmentRelationsTest extends AbstractTestCase
{

    public function testWorkDetails()
    {
        $this->mockBasicModelRelation(
            Department::class,
            'workDetails',
            'hasMany',
            WorkDetail::class
        );
    }
}
