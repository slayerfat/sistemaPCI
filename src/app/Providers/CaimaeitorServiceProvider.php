<?php

namespace PCI\Providers;

use Illuminate\Support\ServiceProvider;
use PCI\Mamarrachismo\Caimaneitor\Caimaneitor;

/**
 * Class CaimaeitorServiceProvider
 * @package PCI\Providers
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class CaimaeitorServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     * @return void
     */
    public function register()
    {
        app()->bind('caimaneitor', function () {
            return new Caimaneitor;
        });
    }
}
