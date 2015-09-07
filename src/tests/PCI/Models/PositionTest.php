<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Position;
use PCI\Models\WorkDetail;
use Tests\AbstractPhpUnitTestCase;

class PositionTest extends AbstractPhpUnitTestCase
{

    public function testWorkDetails()
    {
        $this->mockBasicModelRelation(
            Position::class,
            'workDetails',
            'hasMany',
            WorkDetail::class
        );
    }
}
