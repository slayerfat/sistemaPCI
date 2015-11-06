<?php namespace Tests\Integration\User;

use PCI\Models\User;
use Tests\Integration\AbstractIntegration;

abstract class AbstractUserIntegration extends AbstractIntegration
{

    /**
     * @var \PCI\Models\User
     */
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = $this->getUser();

        $this->persistData();
    }

    /**
     * @return \PCI\Models\User
     */
    abstract protected function getUser();

    /**
     * @return void
     */
    abstract protected function persistData();

    public function getGenericAdmin()
    {
        return factory(User::class)->create([
            'profile_id'        => User::ADMIN_ID,
            'confirmation_code' => null,
        ]);
    }
}
