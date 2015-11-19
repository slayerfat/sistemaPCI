<?php namespace PCI\Models\Traits;

/**
 * Trait HasSlugUID
 *
 * @package PCI\Models\Traits
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 * @property string $slug
 */
trait HasSlugUID
{

    /**
     * Determina cual es el identificador que utilizara el controlador
     *
     * @return string
     */
    public function controllerUID()
    {
        return $this->slug;
    }
}
