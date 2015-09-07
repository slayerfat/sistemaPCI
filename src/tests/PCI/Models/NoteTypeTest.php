<?php namespace Tests\PCI\Models;

use PCI\Models\Note;
use PCI\Models\NoteType;
use Tests\AbstractPhpUnitTestCase;

class NoteTypeTest extends AbstractPhpUnitTestCase
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
