<?php

namespace PCI\Listeners;

use Illuminate\Contracts\Mail\Mailer;
use PCI\Events\NewUserRegistration;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailUserConfirmation
{

    /**
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
     * Handle the event.
     *
     * @param  NewUserRegistration  $event
     * @return void
     */
    public function handle(NewUserRegistration $event)
    {
        $user = $event->user;

        $email = $event->user->email;

        $this->mail->send('emails.verify', compact('user'), function ($message) use ($email) {
            $message->to($email)
                ->subject('Bienvenido al sistemaPCI! por favor verifique su cuenta.');
        });
    }
}
