<?php

namespace PCI\Providers;

use Illuminate\Support\ServiceProvider;
use PCI\Http\ViewComposers\NavbarViewComposer;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Using class based composers...
        view()->composer(
            'partials.navbar',
            NavbarViewComposer::class
        );
    }
}
