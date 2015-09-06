<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Address;
use PCI\Models\Parish;
use PCI\Models\Town;
use Tests\AbstractPhpUnitTestCase;

class ParishTest extends AbstractPhpUnitTestCase
{

    public function testAddresses()
    {
        $model = Mockery::mock(Parish::class)
            ->makePartial();

        $model->shouldReceive('hasMany')
            ->once()
            ->with(Address::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->addresses());
    }

    public function testTown()
    {
        $model = Mockery::mock(Parish::class)
            ->makePartial();

        $model->shouldReceive('belongsTo')
            ->once()
            ->with(Town::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->town());
    }
}
