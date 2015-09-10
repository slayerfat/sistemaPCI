<?php namespace Tests\PCI\Models;

use PCI\Models\Note;
use PCI\Models\NoteType;
use Tests\BaseTestCase;

class NoteTypeTest extends BaseTestCase
{

    public function testNotes()
    {
        $this->mockBasicModelRelation(
            NoteType::class,
            'notes',
            'hasMany',
            Note::class
        );
    }
}
