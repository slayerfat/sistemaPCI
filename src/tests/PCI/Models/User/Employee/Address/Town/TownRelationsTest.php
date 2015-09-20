<?php namespace Tests\PCI\Models\User\Employee\Address\Town;

use Mockery;
use PCI\Models\Parish;
use PCI\Models\State;
use PCI\Models\Town;
use Tests\AbstractTestCase;

class TownRelationsTest extends AbstractTestCase
{

    public function testState()
    {
        $this->mockBasicModelRelation(
            Town::class,
            'state',
            'belongsTo',
            State::class
        );
    }

    public function testParishes()
    {
        $this->mockBasicModelRelation(
            Town::class,
            'parishes',
            'hasMany',
            Parish::class
        );
    }
}
