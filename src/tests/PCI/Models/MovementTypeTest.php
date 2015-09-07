<?php namespace Tests\PCI\Models;

use PCI\Models\Movement;
use PCI\Models\MovementType;
use Tests\AbstractPhpUnitTestCase;

class MovementTypeTest extends AbstractPhpUnitTestCase
{

    public function testMovements()
    {
        $this->mockBasicModelRelation(
            MovementType::class,
            'movements',
            'hasMany',
            Movement::class
        );
    }
}
