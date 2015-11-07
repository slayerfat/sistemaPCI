<?php namespace PCI\Events\Note;

use PCI\Events\Item\AbstractItemMovement;
use PCI\Models\Note;

/**
 * Class NewNoteCreation
 *
 * @package PCI\Events\Note
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class NewNoteCreation extends AbstractItemMovement
{

    /**
     * La nota relacionada a este evento.
     *
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
        parent::__construct($note);
    }

    /**
     * Necesitamos saber cual es la relacion padre, como la herencia de esta
     * clase poseen diferentes padres, debemos hacer este metodo abstracto.
     *
     * @return string
     */
    protected function getParent()
    {
        return 'note';
    }
}
