<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Nationality;
use PCI\Models\UserDetail;
use Tests\AbstractPhpUnitTestCase;

class NationalityTest extends AbstractPhpUnitTestCase
{
    public function testUserDetails()
    {
        $model = Mockery::mock(Nationality::class)
            ->makePartial();

        $model->shouldReceive('hasMany')
            ->once()
            ->with(UserDetail::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->userDetails());
    }
}
