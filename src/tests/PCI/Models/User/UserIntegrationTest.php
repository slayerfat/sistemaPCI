<?php namespace Tests\PCI\Models\User;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PCI\Models\Address;
use PCI\Models\Employee;
use PCI\Models\User;
use Tests\BaseTestCase;

class UserIntegrationTest extends BaseTestCase
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
}
