<?php

namespace PCI\Http;

use PCI\Http\Middleware\Authenticate;
use PCI\Http\Middleware\EncryptCookies;
use PCI\Http\Middleware\VerifyCsrfToken;
use PCI\Http\Middleware\RedirectIfNotAdmin;
use PCI\Http\Middleware\RedirectIfNotVerified;
use PCI\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'       => Authenticate::class,
        'unverified' => RedirectIfNotVerified::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest'      => RedirectIfAuthenticated::class,
        'admin'      => RedirectIfNotAdmin::class,
    ];
}
