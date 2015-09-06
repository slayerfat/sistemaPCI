<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Department;
use PCI\Models\Position;
use PCI\Models\WorkDetail;
use Tests\AbstractPhpUnitTestCase;

class WorkDetailTest extends AbstractPhpUnitTestCase
{

    public function testPosition()
    {
        $model = Mockery::mock(WorkDetail::class)
            ->makePartial();

        $model->shouldReceive('belongsTo')
            ->once()
            ->with(Position::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->position());
    }

    public function testDepartment()
    {
        $model = Mockery::mock(WorkDetail::class)
            ->makePartial();

        $model->shouldReceive('belongsTo')
            ->once()
            ->with(Department::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->department());
    }
}
