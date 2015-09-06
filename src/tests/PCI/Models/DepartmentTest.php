<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Department;
use PCI\Models\WorkDetail;
use Tests\AbstractPhpUnitTestCase;

class DepartmentTest extends AbstractPhpUnitTestCase
{

    public function testWorkDetails()
    {
        $model = Mockery::mock(Department::class)
            ->makePartial();

        $model->shouldReceive('hasMany')
            ->once()
            ->with(WorkDetail::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->workDetails());
    }
}
