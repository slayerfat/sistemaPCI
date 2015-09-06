<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\User;
use PCI\Models\UserDetail;
use Tests\AbstractPhpUnitTestCase;

class UserTest extends AbstractPhpUnitTestCase
{

    public function testDetails()
    {
        $model = Mockery::mock(User::class)
            ->makePartial();

        $model->shouldReceive('hasOne')
            ->once()
            ->with(UserDetail::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->details());
    }
}
