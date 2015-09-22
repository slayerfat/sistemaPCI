<?php namespace Tests\Integration\Aux;

use PCI\Models\User;
use Tests\Integration\AbstractIntegration;

abstract class AbstractAuxIntegration extends AbstractIntegration
{

    /**
     * @var \PCI\Models\User
     */
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create([
            'confirmation_code' => null,
            'profile_id' => User::ADMIN_ID
        ]);
    }
}
