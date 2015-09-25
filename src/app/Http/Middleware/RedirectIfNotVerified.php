<?php

namespace PCI\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use PCI\Models\User;

/**
 * Class RedirectIfNotVerified
 * @package PCI\Http\Middleware
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class RedirectIfNotVerified
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
     *
     * @param  Guard  $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;

        $this->user = $auth->user();
    }

    /**
     * Handle an incoming request.
     * Basicamente lo mismo que admin pero para verficado.
     * @see \PCI\Http\Middleware\RedirectIfNotAdmin
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->user && $this->user->isVerified()) {
            return redirect()->route('index');
        }

        return $next($request);
    }
}
