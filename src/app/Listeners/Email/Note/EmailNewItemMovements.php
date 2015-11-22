<?php namespace PCI\Listeners\Email\Note;

use PCI\Events\Note\NewNoteCreation;
use PCI\Listeners\Email\AbstractItemEmail;
use PCI\Models\Note;

/**
 * Class EmailNewItemMovements
 *
 * @package PCI\Listeners\Email\Note
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class EmailNewItemMovements extends AbstractItemEmail
{

    /**
     * Handle the event.
     *
     * @param \PCI\Events\Note\NewNoteCreation $event
     */
    public function handle(NewNoteCreation $event)
    {
        $note     = $event->note;
        $movement = $this->getMovement($note);
        $user     = $event->note->petition->user;
        $petition = $event->note->petition;

        $this->mail->send(
            [
                'emails.notes.item-movements',
                'emails.notes.item-movements-plain',
            ],
            compact('user', 'petition', 'note', 'movement'),
            function ($message) use ($user, $note, $petition) {
                /** @var \Illuminate\Mail\Message $message */
                $message
                    ->to($user->email)
                    ->cc($this->toCc)
                    ->subject(
                        "sistemaPCI: Nuevos Movimientos relacionados con  "
                        . trans('models.notes.singular')
                        . " #$note->id, "
                        . $note->items->count()
                        . " Items en total."
                    );
            }
        );
    }

    /**
     * @param Note $note
     * @return mixed
     */
    private function getMovement(Note $note)
    {
        $movement = $note->movements->last();

        if (is_null($movement)) {
            throw new \LogicException('Movimiento inexistente');
        }

        return $movement;
    }

    protected function makeEmails()
    {
        $this->findDepotOwnersEmail();
    }
}
