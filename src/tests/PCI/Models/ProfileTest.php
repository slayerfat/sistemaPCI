<?php namespace Tests\PCI\Models;

use PCI\Models\Profile;
use PCI\Models\User;
use Tests\BaseTestCase;

class ProfileTest extends BaseTestCase
{

    public function testUsers()
    {
        $this->mockBasicModelRelation(
            Profile::class,
            'users',
            'hasMany',
            User::class
        );
    }
}
