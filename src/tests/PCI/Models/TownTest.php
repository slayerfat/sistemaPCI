<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Parish;
use PCI\Models\State;
use PCI\Models\Town;
use Tests\AbstractPhpUnitTestCase;

class TownTest extends AbstractPhpUnitTestCase
{

    public function testState()
    {
        $model = Mockery::mock(Town::class)
            ->makePartial();

        $model->shouldReceive('belongsTo')
            ->once()
            ->with(State::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->state());
    }

    public function testParishes()
    {
        $model = Mockery::mock(Town::class)
            ->makePartial();

        $model->shouldReceive('hasMany')
            ->once()
            ->with(Parish::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->parishes());
    }
}
