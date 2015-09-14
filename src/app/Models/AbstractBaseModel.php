<?php namespace PCI\Models;

use Auth;
use Eloquent;
use Log;
use LogicException;

/**
 * Class AbstractBaseModel
 *
 * @package PCI\Models
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 * Se suprime esta advertencia por ser todos los hijos
 * modelos eloquens que contienen el metodo boot igual.
 */
class AbstractBaseModel extends Eloquent
{

    /**
     * Automaticamente manipula los campos de control
     * created/update
     *
     * @throws LogicException
     */
    public static function boot()
    {
        parent::boot();

        $id = Auth::id();

        /**
         * se necesita saber si existe un usuario autenticado en el sistema,
         * para guardar su id, de no ser asi, es necesario saber si estamos
         * o no en produccion o en ambiente local para saber si tirar
         * una exception o continuar porque estamos en el medio
         * de una migracion en el sistema.
         */
        if (is_null($id) && !app()->environment() == 'local') {
            throw new LogicException('Se necesita el ID del usuario actual para manipular este modelo.');
        } elseif (is_null($id) && app()->environment() == 'local') {
            Log::critical(__CLASS__.' no pudo encontrar en '.__METHOD__.' ID para la manipulacion.');

            $id = 1;
        }

        static::creating(function ($model) use ($id) {
            $model->created_by = $id;
            $model->updated_by = $id;
        });

        static::updating(function ($model) use ($id) {
            $model->updated_by = $id;
        });
    }
}
