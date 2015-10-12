<?php namespace PCI\Listeners\Email;

use Date;
use Illuminate\Mail\Message;
use PCI\Events\NewPetitionCreation;

/**
 * Class EmailPetitionEventToCreator
 *
 * @package PCI\Listeners
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class EmailPetitionEventToCreator extends AbstractEmailListener
{

    /**
     * Handle the event.
     *
     * @param  NewPetitionCreation $event
     * @return void
     */
    public function handle(NewPetitionCreation $event)
    {
        $petition = $event->petition;
        $user     = $event->user;
        $email    = $user->email;
        $date     = Date::now();

        $this->mail->send(
            [
                'emails.petitions.created-creator',
                'emails.petitions.created-creator-plain',
            ],
            compact('user', 'petition'),
            function ($message) use ($email, $user, $petition, $date) {
                /** @var Message $message */
                $message->to($email)
                    ->subject(
                        "sistemaPCI: Su ."
                        . trans('models.petitions.singular')
                        . " #" . $petition->id
                        . " con fecha de " . $date
                        . " ha sido creado por correctamente!" . $user->email
                    );
            }
        );
    }
}
