<?php namespace Tests\PCI\Models;

use PCI\Models\Petition;
use PCI\Models\PetitionType;
use Tests\AbstractPhpUnitTestCase;

class PetitionTypeTest extends AbstractPhpUnitTestCase
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
