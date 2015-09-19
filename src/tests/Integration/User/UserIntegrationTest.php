<?php namespace Tests\Integration\User;

use PCI\Models\User;
use Tests\Integration\AbstractIntegrationTest;

class UserIntegrationTest extends AbstractIntegrationTest
{

    /**
     * @var \PCI\Models\User
     */
    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create([
            'profile_id' => User::ADMIN_ID,
            'confirmation_code' => null,
        ]);
    }

    public function testGenericTableShouldBeACollectionVariable()
    {
        $this->markTestIncomplete('falta ajustar');
        $this->actingAs($this->user)
            ->visit('usuarios')
            ->see($this->user->name);

        factory(User::class, 5)->create();

        $this->actingAs($this->user)
            ->visit('usuarios')
            ->see($this->user->name);
    }
}
