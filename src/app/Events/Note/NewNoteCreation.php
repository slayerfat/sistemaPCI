<?php namespace PCI\Events\Note;

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
     * La nota relacionada a este evento.
     *
     * @var \PCI\Models\Note
     */
    public $note;

    /**
     * La coleccion de items relacionados a la nota.
     *
     * @var \Illuminate\Database\Eloquent\Collection|\PCI\Models\Item[]
     */
    public $items;

    /**
     * Create a new event instance.
     *
     * @param \PCI\Models\Note $note
     */
    public function __construct(Note $note)
    {
        $this->note  = $note;
        $this->items = $note->items;
    }
}
