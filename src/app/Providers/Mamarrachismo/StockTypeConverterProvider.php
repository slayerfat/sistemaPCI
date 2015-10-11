<?php namespace PCI\Providers\Mamarrachismo;

use Illuminate\Support\ServiceProvider;
use PCI\Mamarrachismo\Converter\interfaces\StockTypeConverterInterface;
use PCI\Mamarrachismo\Converter\StockTypeConverter;

/**
 * Class StockTypeConverterProvider
 *
 * @package PCI\Providers\Mamarrachismo
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class StockTypeConverterProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StockTypeConverterInterface::class, function () {
            return new StockTypeConverter;
        });
    }
}
