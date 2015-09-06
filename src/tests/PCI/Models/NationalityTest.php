<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Nationality;
use PCI\Models\Employee;
use Tests\AbstractPhpUnitTestCase;

class NationalityTest extends AbstractPhpUnitTestCase
{
    public function testUserDetails()
    {
        $model = Mockery::mock(Nationality::class)
            ->makePartial();

        $model->shouldReceive('hasMany')
            ->once()
            ->with(Employee::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->employee());
    }
}
