<?php namespace Tests\PCI\Models\Note\Movement\Type;

use PCI\Models\Movement;
use PCI\Models\MovementType;
use Tests\BaseTestCase;

class MovementTypeTest extends BaseTestCase
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
