<?php namespace PCI\Models\Traits;

/**
 * Trait HasTernaryStatusAttribute
 *
 * @package PCI\Models\Traits
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
trait HasTernaryStatusAttribute
{

    /**
     * Regresa el estatus en forma textual del pedido.
     *
     * @return string
     */
    public function getFormattedStatusAttribute()
    {
        if (is_null($this->status)) {
            return 'Por aprobar';
        }

        return $this->status ? 'Aprobado' : 'No Aprobado';
    }

    /**
     * Regresa el valor correcto del status segun su estado.
     *
     * @param $value
     * @return int|null
     */
    public function getStatusAttribute($value)
    {
        if (is_null($value)) {
            return null;
        }

        return $value ? 1 : 0;
    }

    /**
     * Ajusta el valor para que sea guardado correctamente en la base de datos.
     *
     * @param $value
     * @return int|null
     */
    public function setStatusAttribute($value)
    {
        if ($value == "true") {
            return $this->attributes['status'] = 1;
        } elseif ($value == "null" || $value == null) {
            return $this->attributes['status'] = null;
        }

        return $this->attributes['status'] = 0;
    }
}
