<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Address;
use PCI\Models\Parish;
use PCI\Models\Town;
use Tests\BaseTestCase;

class ParishTest extends BaseTestCase
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
