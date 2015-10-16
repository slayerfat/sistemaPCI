<?php namespace PCI\Listeners\Email;

use Illuminate\Contracts\Mail\Mailer;

/**
 * Class AbstractEmailListener
 *
 * @package PCI\Listeners\Email
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
abstract class AbstractEmailListener
{

    /**
     * La implementacion del Mailer para enviar correos.
     *
     * @var Mailer
     */
    protected $mail;

    /**
     * Crea el event listener.
     *
     * @param Mailer $mail
     */
    public function __construct(Mailer $mail)
    {
        $this->mail = $mail;
    }
}
