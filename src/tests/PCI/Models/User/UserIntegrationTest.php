<?php namespace Tests\PCI\Models\User;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PCI\Models\Address;
use PCI\Models\Employee;
use PCI\Models\Profile;
use PCI\Models\User;
use Tests\AbstractTestCase;

class UserIntegrationTest extends AbstractTestCase
{

    use DatabaseTransactions, DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->runDatabaseMigrations();
    }

    public function testUserAddressShouldReturnAnObject()
    {
        $user = factory(User::class)->create();
        $address = factory(Address::class)->create(['parish_id' => 1]);
        $employee = factory(Employee::class)->make(['address_id' => $address->id]);

        $user->employee()->save($employee);

        $this->assertEquals($address->street, $user->address->street);
    }

    public function testUserProfileConstantsShouldMatchProfileIds()
    {
        // por alguna razon que no tengo tiempo de investgar
        // si se utiliza un data provider, se queja
        // porque no consigue a la clase Eloquent
        // desde el AbstractModel
        $array = [
            [Profile::whereDesc('Administrador')->firstOrFail()->id, User::ADMIN_ID],
            [Profile::whereDesc('Usuario')->firstOrFail()->id, User::USER_ID],
            [Profile::whereDesc('Desactivado')->firstOrFail()->id, User::DISABLED_ID],
        ];

        foreach ($array as $data) {
            $this->assertEquals($data[0], $data[1]);
        }
    }
}
