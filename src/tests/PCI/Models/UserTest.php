<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Note;
use PCI\Models\User;
use PCI\Models\Employee;
use Tests\AbstractPhpUnitTestCase;

class UserTest extends AbstractPhpUnitTestCase
{

    public function testDetails()
    {
        $this->mockBasicModelRelation(
            User::class,
            'employee',
            'hasOne',
            Employee::class
        );
    }

    public function testNotes()
    {
        $this->mockBasicModelRelation(
            User::class,
            'notes',
            'hasMany',
            Note::class
        );
    }
}
