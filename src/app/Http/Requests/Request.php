<?php namespace PCI\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Request
 * @package PCI\Http\Requests
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
abstract class Request extends FormRequest
{

    /**
     * Cuando algun request es denegado, este es el metodo
     * por defecto que FormRequest ejecuta automaticamente.
     * En este caso nos interesa que muestre un mensaje
     * de error y redireccione de vuelta
     * a donde estaba el usuario.
     * @see FormRequest.
     * @return \Illuminate\Http\Response
     */
    public function forbiddenResponse()
    {
        flash()->error(trans('defaults.auth.error'));

        return redirect()->back();
    }

    /**
     * si el metodo es POST, se esta creando un nuevo usuario
     * lo que implica que el middleware de admin tuvo que
     * ser activado antes de caer a este request.
     *
     * @return bool
     */
    protected function creating()
    {
        return $this->method() == 'POST';
    }
}
