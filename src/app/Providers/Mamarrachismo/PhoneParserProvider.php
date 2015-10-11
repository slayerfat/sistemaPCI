<?php namespace PCI\Providers\Mamarrachismo;

use Illuminate\Support\ServiceProvider;
use PCI\Mamarrachismo\PhoneParser\Interfaces\PhoneParserInterface;
use PCI\Mamarrachismo\PhoneParser\PhoneParser;

/**
 * Class PhoneParserProvider
 * @package PCI\Providers
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
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
