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

        // debemos obviar a este correo si es encargado o jefe de almacen.
        $this->purgeEmails($user->email);

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
                        . " ha sido creado por Usuario "
                        . "$user->name ($user->email)"
                        . " con fecha de " . $date . "."
                    );
            }
        );
    }

    /**
     * Elimina de los correos principales alguno que
     * exista en los CC para no enviarlo dos veces.
     *
     * @param string $email
     *
     * @return void
     */
    protected function purgeEmails($email)
    {
        $data = [$this->emails, $this->toCc];

        foreach ($data as $i => $collection) {
            foreach ($collection as $key => $value) {
                if ($value == $email) {
                    $attr = $i == 0 ? 'emails' : 'toCc';
                    $this->$attr->forget($key);
                }
            }
        }
    }

    protected function makeEmails()
    {
        $this->findDepotOwnersEmail();
        $this->getAttendantsEmail();
    }
}
