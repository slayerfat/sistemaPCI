<?php namespace Tests\PCI\Models\Note\Movement\Type;

use PCI\Models\Movement;
use PCI\Models\MovementType;
use Tests\AbstractTestCase;

class MovementTypeTest extends AbstractTestCase
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
