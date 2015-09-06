<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Position;
use PCI\Models\WorkDetail;
use Tests\AbstractPhpUnitTestCase;

class PositionTest extends AbstractPhpUnitTestCase
{

    public function testWorkDetails()
    {
        $model = Mockery::mock(Position::class)
            ->makePartial();

        $model->shouldReceive('hasMany')
            ->once()
            ->with(WorkDetail::class)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->workDetails());
    }
}
