<?php namespace PCI\Listeners\Email;

use PCI\Events\NewPetitionCreation;

/**
 * Class EmailPetitionEventToAttendants
 *
 * @package PCI\Listeners
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class EmailPetitionEventToAttendants extends AbstractEmailListener
{

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
