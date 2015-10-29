<?php namespace PCI\Listeners\Email\Note;

use PCI\Events\Note\NewNoteCreation;
use PCI\Listeners\Email\AbstractEmailListener;
use PCI\Models\Depot;
use PCI\Models\User;

/**
 * Class EmailNewItemMovements
 *
 * @package PCI\Listeners\Email\Note
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class EmailNewItemMovements extends AbstractEmailListener
{

    /**
     * Handle the event.
     *
     * @param \PCI\Events\Note\NewNoteCreation $event
     */
    public function handle(NewNoteCreation $event)
    {
        $user     = $event->note->petition->user;
        $note     = $event->note;
        $petition = $event->note->petition;
        $movement = $note->movements->last();

        $emails = $this->findDepotOwnersEmail();

        $this->mail->send(
            [
                'emails.notes.item-movements',
                'emails.notes.item-movements-plain',
            ],
            compact('user', 'petition', 'note', 'movement'),
            function ($message) use ($user, $note, $petition, $emails) {
                /** @var \Illuminate\Mail\Message $message */
                $message->to($user->email)->bcc($emails)->subject(
                    "sistemaPCI: Nuevos Movimientos relacionados con  "
                    . trans('models.notes.singular')
                    . " #$note->id, "
                    . $note->items->count()
                    . "Items en total."
                );
            }
        );
    }

    /**
     * @return array
     */
    private function findDepotOwnersEmail()
    {
        $emails = [];

        $owners = $this->findDepotOwners();

        foreach ($owners as $owner) {
            $emails[] = $owner->email;
        }

        return $emails;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function findDepotOwners()
    {
        $ids    = Depot::groupBy('user_id')->lists('user_id')->toArray();
        $owners = User::find($ids);

        return $owners;
    }
}
