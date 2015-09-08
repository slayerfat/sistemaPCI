<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\State;
use PCI\Models\Town;
use Tests\BaseTestCase;

class StateTest extends BaseTestCase
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
