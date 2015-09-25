<?php namespace PCI\Mamarrachismo\Bootstrapper;

use Bootstrapper\Attributes;
use Bootstrapper\Bridges\Config\Laravel5Config;
use Bootstrapper\Exceptions\IconException;

/**
 * Class IconPCI
 * @package PCI\Mamarrachismo\Bootstrapper
 * Pasamos por la penosa tarea de extender la clase
 * original para cambiar un simple detalle.
 * @author Alejandro Granadillo <slayerfat@gmail.com> *
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class IconPCI extends \Bootstrapper\Icon
{

    public function __construct()
    {
        parent::__construct(new Laravel5Config(
            app()->make('config')
        ));
    }

    /**
     * reescribimos render para que nos devuelva <i> en vez de <span>
     * @return string
     * @throws \Bootstrapper\Exceptions\IconException
     */
    public function render()
    {
        if (is_null($this->icon)) {
            throw IconException::noIconSpecified();
        }

        $baseClass = $this->config->getIconPrefix();
        $icon = $this->icon;
        $attributes = new Attributes(
            $this->attributes,
            [
                'class' => "$baseClass $baseClass-$icon"
            ]
        );

        return "<i $attributes></i>";
    }
}
