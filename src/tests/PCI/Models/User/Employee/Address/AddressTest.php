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

        $this->address = new Address();
        $this->address->building = 'guayabita.';
        $this->address->street = 'guayabera.';
        $this->address->av = 'perez.';
    }

    public function testFormattedBuilding()
    {
        $this->assertEquals(
            'Edf./Qta./Blq. Guayabita',
            $this->address->formattedBuilding()
        );
    }

    public function testFormattedStreet()
    {
        $this->assertEquals(
            'Calle(s) Guayabera',
            $this->address->formattedStreet()
        );
    }

    public function testFormattedAv()
    {
        $this->assertEquals(
            'Av. Perez',
            $this->address->formattedAv()
        );
    }

    public function testFormattedDetails()
    {
        $this->assertEquals(
            'Edf./Qta./Blq. Guayabita, Calle(s) Guayabera, Av. Perez',
            $this->address->formattedDetails
        );
    }

    public function testFomattedMethodsShouldReturn()
    {
        $this->address->building = null;
        $this->address->street = null;
        $this->address->av = null;

        $this->assertEquals(
            '',
            $this->address->formattedDetails
        );
    }
}
