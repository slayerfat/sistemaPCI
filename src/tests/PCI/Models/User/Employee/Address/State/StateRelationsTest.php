<?php namespace Tests\PCI\Models\User\Employee\Address\State;

use Mockery;
use PCI\Models\State;
use PCI\Models\Town;
use Tests\AbstractTestCase;

class StateRelationsTest extends AbstractTestCase
{

    public function testTowns()
    {
        $this->mockBasicModelRelation(
            State::class,
            'towns',
            'hasMany',
            Town::class
        );
    }
}
