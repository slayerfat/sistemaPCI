<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\State;
use PCI\Models\Town;
use Tests\AbstractPhpUnitTestCase;

class StateTest extends AbstractPhpUnitTestCase
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
