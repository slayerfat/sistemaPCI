<?php

namespace PCI\Providers;

use Illuminate\Support\ServiceProvider;
use PCI\Mamarrachismo\Caimaneitor\Caimaneitor;

class CaimaeitorServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind('caimaneitor', function () {
            return new Caimaneitor;
        });
    }
}
