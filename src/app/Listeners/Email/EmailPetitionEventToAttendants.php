<?php namespace PCI\Listeners\Email;

use Date;
use Illuminate\Mail\Message;
use PCI\Events\Petition\NewPetitionCreation;
use PCI\Models\Attendant;
use PCI\Models\Depot;

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
     * @param  \PCI\Events\Petition\NewPetitionCreation $event
     * @return void
     */
    public function handle(NewPetitionCreation $event)
    {
        $petition             = $event->petition;
        $user                 = $event->user;
        $date                 = Date::now();
        $emails['attendants'] = $this->getAttendantsEmail();
        $emails['owner']      = $this->getOwnerEmail();

        $this->mail->send(
            [
                'emails.petitions.created-attendants',
                'emails.petitions.created-attendants-plain',
            ],
            compact('user', 'petition'),
            function ($message) use ($emails, $user, $petition, $date) {
                /** @var Message $message */
                $message->to($emails['attendants'])
                    ->bcc($emails['owner'])
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

    /**
     * Busca los correos de los encargados de almacen en el sistema.
     *
     * @return array
     */
    protected function getAttendantsEmail()
    {
        $emails = [];

        // TODO: repo
        Attendant::all()->load('user')
            ->each(function ($attendant) use (&$emails) {
                $emails[] = $attendant->user->email;
            });

        return $emails;
    }

    /**
     * Regresa el correo del jefe de almacen.
     *
     * @return string
     */
    protected function getOwnerEmail()
    {
        // TODO: repo
        return Depot::first()->owner->email;
    }
}
