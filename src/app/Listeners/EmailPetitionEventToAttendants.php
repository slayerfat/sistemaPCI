<?php namespace PCI\Listeners;

use PCI\Events\NewPetitionCreation;

/**
 * Class EmailPetitionEventToAttendants
 *
 * @package PCI\Listeners
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class EmailPetitionEventToAttendants
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewPetitionCreation $event
     * @return void
     */
    public function handle(NewPetitionCreation $event)
    {
        //
    }
}
