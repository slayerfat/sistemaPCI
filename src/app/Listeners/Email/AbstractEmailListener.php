<?php namespace PCI\Listeners\Email;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Collection;

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
     * @var \Illuminate\Support\Collection
     */
    protected $emails;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $toCc;

    /**
     * @var string
     */
    protected $toBcc;

    /**
     * Crea el event listener.
     *
     * @param Mailer $mail
     */
    public function __construct(Mailer $mail)
    {
        $this->mail   = $mail;
        $this->emails = new Collection;
        $this->toCc   = new Collection;
        $this->makeEmails();
    }

    abstract protected function makeEmails();
}
