<?php namespace PCI\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use PCI\Models\User;

/**
 * Class Authenticate
 * @package PCI\Http\Middleware
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * @var User|null
     */
    protected $user;


    /**
     * Create a new filter instance.
     * @param  Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;

        $this->user = $auth->user();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            }

            // si la peticion no es ajax entonces
            // se redirecciona al login
            return redirect()->guest('sesion/iniciar');
        }

        // si el usuario todavia no ha verificado su cuenta.
        if ($this->user->isUnverified()) {
            return redirect()->route('index.unverified');
        }

        return $next($request);
    }
}
