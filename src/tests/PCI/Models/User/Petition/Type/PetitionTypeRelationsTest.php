<?php namespace Tests\PCI\Models\User\Petition\Type;

use PCI\Models\MovementType;
use PCI\Models\Petition;
use PCI\Models\PetitionType;
use Tests\AbstractTestCase;

class PetitionTypeRelationsTest extends AbstractTestCase
{

    public function testPetitions()
    {
        $this->mockBasicModelRelation(
            PetitionType::class,
            'petitions',
            'hasMany',
            Petition::class
        );
    }

    public function testMovementTypes()
    {
        $this->mockBasicModelRelation(
            PetitionType::class,
            'movementType',
            'belongsTo',
            MovementType::class
        );
    }
}
