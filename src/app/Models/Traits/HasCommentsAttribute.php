<?php namespace PCI\Models\Traits;

/**
 * Trait HasCommentsAttribute
 *
 * @package PCI\Models\Traits
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
trait HasCommentsAttribute
{

    /**
     * Regresa los comentarios, si estan vacios, regresa 'sin comentarios'.
     *
     * @param string $value
     * @return string
     */
    public function getCommentsAttribute($value)
    {
        return strlen($value) > 1 ? $value : 'Sin comentarios.';
    }
}
