<?php namespace PCI\Http\Middleware;

use Closure;
use Flash;
use Redirect;

class RedirectIfNotAdmin
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->isAdmin()) {
            return $next($request);
        }

        Flash::error(trans('defaults.auth.error'));

        return Redirect::back();
    }
}
