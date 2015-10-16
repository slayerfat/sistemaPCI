<?php namespace PCI\Listeners\Email;

use PCI\Events\Petition\PetitionApprovalRequest;

/**
 * Class EmailApprovalRequestToAttendants
 *
 * @package PCI\Listeners\Email
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class EmailApprovalRequestToAttendants extends EmailPetitionEventToAttendants
{

    /**
     * Handle the event.
     *
     * @param \PCI\Events\Petition\PetitionApprovalRequest $event
     */
    public function handle(PetitionApprovalRequest $event)
    {
        $petition             = $event->petition;
        $user                 = $event->user;
        $emails['attendants'] = $this->getAttendantsEmail();
        $emails['owner']      = $this->getOwnerEmail();

        $this->mail->send(
            [
                'emails.petitions.approval-request-attendants',
                'emails.petitions.approval-request-attendants-plain',
            ],
            compact('user', 'petition'),
            function ($message) use ($emails, $user, $petition) {
                /** @var \Illuminate\Mail\Message $message */
                $message->to($emails['attendants'])->bcc($emails['owner'])->subject(
                    "sistemaPCI: Usuario " . $user->name
                    . " ha solicitado la aprobación del "
                    . trans('models.petitions.singular')
                    . " #$petition->id"
                );
            }
        );
    }
}
