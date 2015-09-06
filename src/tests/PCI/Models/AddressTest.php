<?php namespace Tests\PCI\Models;

use PCI\Models\Address;
use PCI\Models\Parish;
use PCI\Models\UserDetail;
use Tests\AbstractPhpUnitTestCase;

class AddressTest extends AbstractPhpUnitTestCase
{

    public function testParishRelation()
    {
        $model = \Mockery::mock(Address::class)
            ->makePartial();

        $model->shouldReceive('belongsTo')
            ->once()
            ->with(Parish::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->parish());
    }

    public function testUserDetailsRelation()
    {
        $model = \Mockery::mock(Address::class)
            ->makePartial();

        $model->shouldReceive('hasMany')
            ->once()
            ->with(UserDetail::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->userDetails());
    }
}
