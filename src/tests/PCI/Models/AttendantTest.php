<?php namespace Tests\PCI\Models;

use PCI\Models\Attendant;
use PCI\Models\Employee;
use PCI\Models\Note;
use Tests\AbstractPhpUnitTestCase;

class AttendantTest extends AbstractPhpUnitTestCase
{

    public function testEmployee()
    {
        $this->mockBasicModelRelation(
            Attendant::class,
            'employee',
            'belongsTo',
            Employee::class
        );
    }

    public function testNotes()
    {
        $this->mockBasicModelRelation(
            Attendant::class,
            'notes',
            'hasMany',
            Note::class
        );
    }
}
