<?php namespace PCI\Listeners\Email;

use Date;
use Illuminate\Mail\Message;
use PCI\Events\Petition\NewPetitionCreation;

/**
 * Class EmailPetitionEventToAttendants
 *
 * @package PCI\Listeners
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class EmailPetitionEventToAttendants extends AbstractItemEmail
{

    /**
     * Handle the event.
     *
     * @param  \PCI\Events\Petition\NewPetitionCreation $event
     * @return void
     */
    public function handle(NewPetitionCreation $event)
    {
        $petition = $event->petition;
        $user     = $event->user;
        $date     = Date::now();

        $this->mail->send(
            [
                'emails.petitions.created-attendants',
                'emails.petitions.created-attendants-plain',
            ],
            compact('user', 'petition'),
            function ($message) use ($user, $petition, $date) {
                /** @var Message $message */
                $message
                    ->to($this->emails->all())
                    ->cc($this->toCc->all())
                    ->subject(
                        "sistemaPCI: Nuevo "
                        . trans('models.petitions.singular')
                        . " #" . $petition->id
                        . " ha sido creado por " . $user->email
                        . " con fecha de " . $date . "."
                    );
            }
        );
    }

    protected function makeEmails()
    {
        $this->findDepotOwnersEmail();
        $this->getAttendantsEmail();
    }
}
