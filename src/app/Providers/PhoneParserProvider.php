<?php namespace PCI\Providers;

use Illuminate\Support\ServiceProvider;
use PCI\Mamarrachismo\PhoneParser\Interfaces\PhoneParserInterface;
use PCI\Mamarrachismo\PhoneParser\PhoneParser;

/**
 * Class PhoneParserProvider
 * @package PCI\Providers
 */
class PhoneParserProvider extends ServiceProvider
{

    /**
     * Registra el PhoneParser del mamarrachismo
     * Usado para primordialmente manipular
     * telefonos a formato legible
     * @return void
     */
    public function register()
    {
        $this->app->bind(PhoneParserInterface::class, function () {
            return new PhoneParser;
        });
    }
}
