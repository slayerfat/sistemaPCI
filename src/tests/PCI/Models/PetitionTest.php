<?php namespace Tests\PCI\Models;

use PCI\Models\Petition;
use PCI\Models\PetitionType;
use Tests\AbstractPhpUnitTestCase;

class PetitionTest extends AbstractPhpUnitTestCase
{

    public function testType()
    {
        $this->mockBasicModelRelation(
            Petition::class,
            'type',
            'belongsTo',
            PetitionType::class
        );
    }
}
