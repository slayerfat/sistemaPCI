<?php namespace PCI\Http\Middleware;

use Closure;
use Flash;
use Redirect;

/**
 * Class RedirectIfNotAdmin
 * @package PCI\Http\Middleware
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class RedirectIfNotAdmin
{

    /**
     * Basicamente si el usuario es admin, lo deja continuar,
     * de lo contrario redireciona con mensaje de error.
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // si es admin, pasa normal.
        if ($request->user()->isAdmin()) {
            return $next($request);
        }

        // de lo contrario es redireccionado con error.
        Flash::error(trans('defaults.auth.error'));

        return Redirect::back();
    }
}
