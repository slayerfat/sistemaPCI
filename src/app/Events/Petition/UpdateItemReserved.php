<?php namespace PCI\Events\Petition;

use Illuminate\Queue\SerializesModels;
use PCI\Events\Item\AbstractItemMovement;
use PCI\Models\Petition;

/**
 * Class UpdateItemReserved
 *
 * @package PCI\Events\Petition
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class UpdateItemReserved extends AbstractItemMovement
{

    use SerializesModels;

    /**
     * La nota relacionada a este evento.
     *
     * @var \PCI\Models\Petition
     */
    public $petition;

    /**
     * Create a new event instance.
     *
     * @param \PCI\Models\Petition $petition
     */
    public function __construct(Petition $petition)
    {
        $this->petition = $petition;
        parent::__construct($petition);
    }

    /**
     * Necesitamos saber cual es la relacion padre, como la herencia de esta
     * clase poseen diferentes padres, debemos hacer este metodo abstracto.
     *
     * @return string
     */
    protected function getParent()
    {
        return 'petition';
    }
}
