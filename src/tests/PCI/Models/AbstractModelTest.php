<?php namespace Tests\PCI\Models;

use PCI\Models\User;
use Tests\AbstractTestCase;

class AbstractModelTest extends AbstractTestCase
{
    /**
     * @var User
     */
    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->make();
    }

    public function testCreatedAndUpdatedByShouldReturnUser()
    {
        $this->assertInstanceOf(User::class, $this->user->createdBy());
        $this->assertInstanceOf(User::class, $this->user->updatedBy());

        unset($this->user->created_by);
        unset($this->user->updated_by);

        $this->assertInstanceOf(User::class, $this->user->createdBy());
        $this->assertInstanceOf(User::class, $this->user->updatedBy());

        $user = $this->user->createdBy();

        $this->assertFalse($user->exists);

        $user = $this->user->updatedBy();

        $this->assertFalse($user->exists);
    }
}
