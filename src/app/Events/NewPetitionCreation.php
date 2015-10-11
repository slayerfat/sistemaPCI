<?php namespace PCI\Events;

use Illuminate\Queue\SerializesModels;
use PCI\Models\Petition;

/**
 * Class NewPetitionCreation
 *
 * @package PCI\Events
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class NewPetitionCreation extends Event
{

    use SerializesModels;

    /**
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
    }
}
