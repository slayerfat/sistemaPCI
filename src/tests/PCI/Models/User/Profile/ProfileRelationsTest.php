<?php namespace Tests\PCI\Models\User\Profile;

use PCI\Models\Profile;
use PCI\Models\User;
use Tests\BaseTestCase;

class ProfileRelationsTest extends BaseTestCase
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
