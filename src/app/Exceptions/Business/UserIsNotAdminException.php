<?php namespace PCI\Exceptions\Business;

use Exception;

/**
 * Class UserIsNotAdminException
 * @package PCI\Providers\Exceptions
 * Por ahora solo exiende a la excepcion.
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class UserIsNotAdminException extends \Exception
{

    public function __construct(
        $message = 'El usuario seleccionado para este almacen no es administrador.',
        $code = 0,
        Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
