<?php namespace PCI\Repositories\ViewVariable\Interfaces;

use Illuminate\Support\Collection;
use PCI\Repositories\ViewVariable\FormViewVariable;

/**
 * interface FormFieldsInterface
 *
 * @package PCI\Repositories\ViewVariable\Interfaces
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
interface FormFieldsInterface
{

    /**
     * Determina si existen campos adicionales.
     *
     * @return bool
     */
    public function hasFields();

    /**
     * Determina si no existen campos adicionales.
     *
     * @return bool
     */
    public function areFieldsEmpty();

    /**
     * Añade un nuevo campo de formulario a la coleccion existente.
     *
     * @param $fields
     */
    public function setFields($fields);

    /**
     * Regresa una coleccion de campos relacionados con el formulario.
     *
     * @return Collection
     */
    public function getFields();
}
