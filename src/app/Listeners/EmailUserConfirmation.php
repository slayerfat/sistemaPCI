<?php

namespace PCI\Listeners;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use PCI\Events\NewUserRegistration;

/**
 * Class EmailUserConfirmation
 * @package PCI\Listeners
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class EmailUserConfirmation implements ShouldQueue
{

    /**
     * La implementacion del Mailer para enviar correos.
     * @var Mailer
     */
    private $mail;

    /**
     * Create the event listener.
     * @param Mailer $mail
     */
    public function __construct(Mailer $mail)
    {
        $this->mail = $mail;
    }

    /**
     * En este evento, enviamos el correo con los datos
     * necesario para que el usuario pueda
     * confirmar su cuenta por medio
     * de la clave de ocnfirmacion.
     * @param  NewUserRegistration  $event
     * @return void
     */
    public function handle(NewUserRegistration $event)
    {
        $user = $event->user;

        $email = $event->user->email;

        $this->mail->send(['emails.verify', 'emails.verify-plain'], compact('user'), function ($message) use ($email) {
            $message->to($email)
                ->subject('sistemaPCI: por favor verifique su cuenta.');
        });
    }
}
