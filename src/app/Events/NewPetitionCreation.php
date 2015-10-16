<?php namespace PCI\Events;

use Illuminate\Queue\SerializesModels;
use PCI\Models\Petition;
use PCI\Models\User;

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
     * @var \PCI\Models\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param \PCI\Models\Petition $petition
     * @param \PCI\Models\User     $user
     */
    public function __construct(Petition $petition, User $user)
    {
        $this->petition = $petition;
        $this->user = $user;
    }
}
