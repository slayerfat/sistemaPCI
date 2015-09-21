<?php namespace Tests\PCI\Models\User\Employee\Address\Parish;

use Mockery;
use PCI\Models\Address;
use PCI\Models\Parish;
use PCI\Models\Town;
use Tests\AbstractTestCase;

class ParishRelationsTest extends AbstractTestCase
{

    public function testAddresses()
    {
        $this->mockBasicModelRelation(
            Parish::class,
            'addresses',
            'hasMany',
            Address::class
        );
    }

    public function testTown()
    {
        $this->mockBasicModelRelation(
            Parish::class,
            'town',
            'belongsTo',
            Town::class
        );
    }
}
