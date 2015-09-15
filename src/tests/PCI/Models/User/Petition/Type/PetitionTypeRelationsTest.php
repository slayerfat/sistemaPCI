<?php namespace Tests\PCI\Models\User\Petition\Type;

use PCI\Models\Petition;
use PCI\Models\PetitionType;
use Tests\BaseTestCase;

class PetitionTypeRelationsTest extends BaseTestCase
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
}
