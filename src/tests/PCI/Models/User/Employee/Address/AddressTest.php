<?php namespace Tests\PCI\Models\User\Employee\Address;

use PCI\Models\Address;
use Tests\BaseTestCase;

class AddressTest extends BaseTestCase
{

    /**
     * @var \PCI\Models\Address
     */
    private $address;

    public function setUp()
    {
        parent::setUp();

        $this->address = factory(Address::class)->make();
    }

    public function testFormattedDetails()
    {
        $this->markTestIncomplete('todo');

        // TODO: desarrollar.
    }
}
