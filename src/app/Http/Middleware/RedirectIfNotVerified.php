<?php

namespace PCI\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use PCI\Models\User;

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
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->user) {
            if ($this->user->isVerified()) {
                return redirect()->route('index');
            }
        }

        return $next($request);
    }
}
