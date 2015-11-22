<?php namespace PCI\Listeners\Email\Note;

use PCI\Events\Note\NewNoteCreation;
use PCI\Listeners\Email\AbstractEmailListener;

/**
 * Class EmailNewNoteToCreator
 *
 * @package PCI\Listeners\Email\Note
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class EmailNewNoteToCreator extends AbstractEmailListener
{

    /**
     * Handle the event.
     *
     * @param \PCI\Events\Note\NewNoteCreation $event
     */
    public function handle(NewNoteCreation $event)
    {
        $user     = $event->note->user;
        $note     = $event->note;
        $petition = $event->note->petition;

        $this->mail->send(
            [
                'emails.notes.created-to-creator',
                'emails.notes.created-to-creator-plain',
            ],
            compact('user', 'petition', 'note'),
            function ($message) use ($user, $note, $petition) {
                /** @var \Illuminate\Mail\Message $message */
                $message->to($user->email)->subject(
                    "sistemaPCI: La "
                    . trans('models.notes.singular')
                    . " #$note->id" . " Relacionada con "
                    . trans('models.petitions.singular')
                    . " #$petition->id, creada exitosamente."
                );
            }
        );
    }

    protected function makeEmails()
    {
        //
    }
}
