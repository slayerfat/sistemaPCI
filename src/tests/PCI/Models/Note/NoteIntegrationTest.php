<?php namespace Tests\PCI\Models\Note;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PCI\Models\MovementType;
use PCI\Models\Note;
use PCI\Models\NoteType;
use Tests\AbstractTestCase;

/**
 * Class NoteIntegrationTest
 *
 * @package Tests\PCI\Models\Note
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class NoteIntegrationTest extends AbstractTestCase
{

    use DatabaseMigrations, DatabaseTransactions;

    /**
     * @var \PCI\Models\Note
     */
    private $note;

    /**
     * @var \PCI\Models\NoteType
     */
    private $noteType;

    public function setUp()
    {
        parent::setUp();

        $this->runDatabaseMigrations();

        // la salida no nos interesa por ahora.
        factory(MovementType::class)->create(['desc' => 'Salida']);

        // generamos las intancias necesarias
        $movement       = factory(MovementType::class)->create(['desc' => 'Entrada']);
        $this->noteType = factory(NoteType::class)->create(['movement_type_id' => $movement->id]);
        $this->note     = factory(Note::class)->create(['note_type_id' => $this->noteType->id]);
    }

    public function testMovementTypeInIsTrue()
    {
        $this->assertTrue($this->note->isMovementTypeIn());
    }

    public function testMovementTypeOutIsFalse()
    {
        $this->assertFalse($this->note->isMovementTypeOut());
    }
}
