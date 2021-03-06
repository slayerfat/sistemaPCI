<?php namespace PCI\Listeners\Email\Note;

use PCI\Events\Note\NewNoteCreation;
use PCI\Listeners\Email\AbstractEmailListener;

/**
 * Class EmailNewNoteToUser
 *
 * @package PCI\Listeners\Email\Note
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class EmailNewNoteToUser extends AbstractEmailListener
{

    /**
     * Handle the event.
     *
     * @param \PCI\Events\Note\NewNoteCreation $event
     */
    public function handle(NewNoteCreation $event)
    {
        $user = $event->note->petition->user;

        // si el creador de la nota es el mismo que creo el pedido,
        // entonces no es necesario enviar algun correo
        if ($user->id = $event->note->user->id) {
            return;
        }

        $note     = $event->note;
        $petition = $event->note->petition;

        $this->mail->send(
            [
                'emails.notes.created-to-user',
                'emails.notes.created-to-user-plain',
            ],
            compact('user', 'petition', 'note'),
            function ($message) use ($user, $note, $petition) {
                /** @var \Illuminate\Mail\Message $message */
                $message->to($user->email)->subject(
                    "sistemaPCI: La "
                    . trans('models.notes.singular')
                    . " #$note->id Relacionada con "
                    . trans('models.petitions.singular')
                    . " #$petition->id, fue creada exitosamente."
                );
            }
        );
    }

    protected function makeEmails()
    {
        //
    }
}
