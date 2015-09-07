<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Department;
use PCI\Models\WorkDetail;
use Tests\AbstractPhpUnitTestCase;

class DepartmentTest extends AbstractPhpUnitTestCase
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
