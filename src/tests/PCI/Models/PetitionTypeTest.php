<?php namespace Tests\PCI\Models;

use PCI\Models\Petition;
use PCI\Models\PetitionType;
use Tests\BaseTestCase;

class PetitionTypeTest extends BaseTestCase
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
