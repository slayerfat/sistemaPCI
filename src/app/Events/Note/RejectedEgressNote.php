<?php namespace PCI\Events\Note;

use PCI\Events\Item\AbstractItemMovement;

/**
 * Class RejectedEgressNote
 *
 * @package PCI\Events\Item
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class RejectedEgressNote extends AbstractItemMovement
{

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
