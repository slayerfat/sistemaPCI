<?php namespace PCI\Events\Item;

use Illuminate\Queue\SerializesModels;
use PCI\Events\Event;
use PCI\Models\AbstractBaseModel;

/**
 * Class AbstractItemMovement
 *
 * @package PCI\Events\Item
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
abstract class AbstractItemMovement extends Event
{

    use SerializesModels;

    /**
     * La coleccion de items relacionados a la nota.
     *
     * @var \Illuminate\Database\Eloquent\Collection|\PCI\Models\Item[]
     */
    public $items;

    /**
     * El padre (relacion Eloquent)
     *
     * @var string
     */
    public $parent;

    /**
     * Create a new event instance.
     *
     * @param \PCI\Models\AbstractBaseModel $model
     */
    public function __construct(AbstractBaseModel $model)
    {
        $this->items  = $model->items;
        $this->parent = $this->getParent();
    }

    /**
     * Necesitamos saber cual es la relacion padre, como la herencia de esta
     * clase poseen diferentes padres, debemos hacer este metodo abstracto.
     *
     * @return string
     */
    abstract protected function getParent();
}
