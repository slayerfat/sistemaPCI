<?php

/**
 * Por ahora esta interface solo sirve como amalgama de las distintas
 * interfaces que el repositorio utliza.
 * Se hizo de esta forma porque cuando se solicita la implementacion
 * de un repositorio se debe dar el que corresponde, es
 * decir, si algun solicita la interfaz de arepas,
 * hay que darle la implementacion de arepas.
 * Pudiera ser mejorado.
 * Al menos esta interfaz demanda implementacion adicional.
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */

namespace PCI\Repositories\Interfaces\User;

use PCI\Repositories\Interfaces\ModelRepositoryInterface;
use PCI\Repositories\Interfaces\RepositoryPaginatorInterface;
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
     * @param string $code El codigo de 32 caracteres.
     * @return bool Verdaredo si existe un usuario con este codigo.
     */
    public function confirmCode($code);

    /**
     * Regresa una arreglo de los usuarios que
     * sean administradores del sistema.
     * @return \Illuminate\Support\Collection
     */
    public function adminLists();
}
