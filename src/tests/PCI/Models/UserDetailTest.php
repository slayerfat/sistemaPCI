<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Address;
use PCI\Models\Gender;
use PCI\Models\Nationality;
use PCI\Models\User;
use PCI\Models\UserDetail;
use PCI\Models\WorkDetail;
use Tests\AbstractPhpUnitTestCase;

class UserDetailTest extends AbstractPhpUnitTestCase
{

    public function testUser()
    {
        $model = Mockery::mock(UserDetail::class)
            ->makePartial();

        $model->shouldReceive('hasOne')
            ->once()
            ->with(User::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->user());
    }

    public function testWorkDetails()
    {
        $model = Mockery::mock(UserDetail::class)
            ->makePartial();

        $model->shouldReceive('hasOne')
            ->once()
            ->with(WorkDetail::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->workDetails());
    }

    public function testNationality()
    {
        $model = Mockery::mock(UserDetail::class)
            ->makePartial();

        $model->shouldReceive('belongsTo')
            ->once()
            ->with(Nationality::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->nationality());
    }

    public function testGender()
    {
        $model = Mockery::mock(UserDetail::class)
            ->makePartial();

        $model->shouldReceive('belongsTo')
            ->once()
            ->with(Gender::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->gender());
    }

    public function testAddress()
    {
        $model = Mockery::mock(UserDetail::class)
            ->makePartial();

        $model->shouldReceive('belongsTo')
            ->once()
            ->with(Address::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->address());
    }
}
