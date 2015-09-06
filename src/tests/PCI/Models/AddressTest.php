<?php namespace Tests\PCI\Models;

use PCI\Models\Address;
use PCI\Models\Parish;
use PCI\Models\Employee;
use Tests\AbstractPhpUnitTestCase;

class AddressTest extends AbstractPhpUnitTestCase
{

    public function testParish()
    {
        $model = \Mockery::mock(Address::class)
            ->makePartial();

        $model->shouldReceive('belongsTo')
            ->once()
            ->with(Parish::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->parish());
    }

    public function testUserDetails()
    {
        $model = \Mockery::mock(Address::class)
            ->makePartial();

        $model->shouldReceive('hasMany')
            ->once()
            ->with(Employee::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->userDetails());
    }
}
