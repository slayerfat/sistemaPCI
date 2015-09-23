<?php namespace Tests\Integration\User;

use PCI\Models\User;

class UserIntegrationTest extends AbstractUserIntegration
{

    public function testGenericTableShouldBeACollectionVariable()
    {
        $this->actingAs($this->user)
             ->visit('usuarios')
             ->see($this->user->name);

        factory(User::class, 5)->create();

        $this->actingAs($this->user)
             ->visit('usuarios')
             ->see($this->user->name);
    }

    /**
     * @return \PCI\Models\User
     */
    protected function getUser()
    {
        return factory(User::class)->create([
            'profile_id' => User::ADMIN_ID,
            'confirmation_code' => null,
        ]);
    }

    /**
     * @return void
     */
    protected function persistData()
    {
        // TODO: Implement persistData() method.
    }
}
