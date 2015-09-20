<?php namespace Tests\PCI\Models\User\Profile;

use PCI\Models\Profile;
use PCI\Models\User;
use Tests\AbstractTestCase;

class ProfileRelationsTest extends AbstractTestCase
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
