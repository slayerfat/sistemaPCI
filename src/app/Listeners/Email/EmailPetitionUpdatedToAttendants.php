<?php namespace PCI\Listeners\Email;

use PCI\Events\Petition\PetitionUpdatedByCreator;

/**
 * Class EmailApprovalRequestToAttendants
 *
 * @package PCI\Listeners\Email
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class EmailPetitionUpdatedToAttendants extends EmailPetitionEventToAttendants
{

    /**
     * Handle the event.
     *
     * @param \PCI\Events\Petition\PetitionUpdatedByCreator $event
     */
    public function handle(PetitionUpdatedByCreator $event)
    {
        $petition             = $event->petition;
        $user                 = $event->user;

        // debemos obviar a este correo si es encargado o jefe de almacen.
        $this->purgeEmails($user->email);

        $this->mail->send(
            [
                'emails.petitions.updated-by-creator-attendants',
                'emails.petitions.updated-by-creator-attendants-plain',
            ],
            compact('user', 'petition'),
            function ($message) use ($user, $petition) {
                /** @var \Illuminate\Mail\Message $message */
                $message->to($this->emails->all())->subject(
                    "sistemaPCI: El usuario $user->name ($user->email)"
                    . " ha actualizado el "
                    . trans('models.petitions.singular')
                    . " #$petition->id"
                );
            }
        );
    }
}
