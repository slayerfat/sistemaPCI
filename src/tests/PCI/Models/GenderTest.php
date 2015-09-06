<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Gender;
use PCI\Models\UserDetail;
use Tests\AbstractPhpUnitTestCase;

class GenderTest extends AbstractPhpUnitTestCase
{

    public function testUserDetails()
    {
        $model = Mockery::mock(Gender::class)
            ->makePartial();

        $model->shouldReceive('hasMany')
            ->once()
            ->with(UserDetail::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->userDetails());
    }
}
