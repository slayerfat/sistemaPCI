<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\State;
use PCI\Models\Town;
use Tests\AbstractPhpUnitTestCase;

class StateTest extends AbstractPhpUnitTestCase
{

    public function testTowns()
    {
        $model = Mockery::mock(State::class)
            ->makePartial();

        $model->shouldReceive('hasMany')
            ->once()
            ->with(Town::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->towns());
    }
}
