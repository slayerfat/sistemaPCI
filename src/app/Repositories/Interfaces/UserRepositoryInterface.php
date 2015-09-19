<?php namespace PCI\Repositories\Interfaces;

use PCI\Repositories\Interfaces\Viewable\GetIndexViewableInterface;

interface UserRepositoryInterface extends
    ModelRepositoryInterface,
    RepositoryPaginatorInterface,
    GetIndexViewableInterface
{

    /**
     * genera un codigo de 32 caracteres para validar
     * al usuario por correo por primera vez.
     * @return \PCI\Models\User
     */
    public function generateConfirmationCode();

    /**
     * confirma el codigo previamente creado.
     *
     * @param string $code
     * @return bool
     */
    public function confirm($code);
}
