<?php namespace Tests\PCI\Models\User\Employee\WorkDetails\Position;

use Mockery;
use PCI\Models\Position;
use PCI\Models\WorkDetail;
use Tests\AbstractTestCase;

class PositionRelationsTest extends AbstractTestCase
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
