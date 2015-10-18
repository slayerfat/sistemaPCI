<?php

namespace PCI\Events\Note;

use Illuminate\Queue\SerializesModels;
use PCI\Events\Event;
use PCI\Models\Note;

/**
 * Class NewNoteCreation
 *
 * @package PCI\Events\Note
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class NewNoteCreation extends Event
{

    use SerializesModels;

    /**
     * @var \PCI\Models\Note
     */
    public $note;

    /**
     * Create a new event instance.
     *
     * @param \PCI\Models\Note $note
     */
    public function __construct(Note $note)
    {
        $this->note = $note;
    }
}
