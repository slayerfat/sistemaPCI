<?php namespace PCI\Models;

use Auth;
use Eloquent;
use Jenssegers\Date\Date;
use Log;
use LogicException;

/**
 * PCI\Models\AbstractBaseModel
 *
*@package PCI\Models
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 * Se suprime esta advertencia por ser todos los hijos
 * modelos Eloquent que contienen el metodo boot igual.
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 * @property-read \Jenssegers\Date\Date $created_at
 * @property-read \Jenssegers\Date\Date $updated_at
 */
abstract class AbstractBaseModel extends Eloquent
{

    /**
     * Los datos necesarios para generarar un slug
     * en el modelo, por defecto es un array
     * con  'build_from' => 'desc',
     *      'save_to'    => 'slug',
     * @var Array
     */
    protected $sluggable;

    /**
     * Atributos que deben ser ocultos en array/json.
     * Si por alguna razon esto debe cambiar, se puede
     * hacer en las clases que concretan esta.
     * @var array
     */
    protected $hidden = [
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    /**
     * Automaticamente manipula los campos de control
     * created/update
     * @throws \LogicException
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
        $env = app()->environment();

        if (is_null($id) && !$env == 'local') {
            throw new LogicException(
                'Se necesita el ID del usuario actual para manipular este modelo.'
            );
        } elseif (is_null($id) && ($env == 'local' || $env == 'testing')) {
            Log::critical(
                __CLASS__ . ' no pudo encontrar en '
                . __METHOD__ . ' ID para la manipulacion.'
            );

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

    /**
     * Determina cual es el identificador que utilizara el controlador
     *
     * @return int|string
     */
    abstract public function controllerUID();

    /**
     * Cuando se pide la fecha de created_at se devuelve una
     * instancia de Date en vez de Carbon\Carbon
     * @param string $value
     * @return \Jenssegers\Date\Date
     */
    public function getCreatedAtAttribute($value)
    {
        return $this->getDateInstance($value);
    }

    /**
     * Regresa la instancia de Date con el valor que
     * tiene en su momento el modelo concreto.
     * @param string $value el valor a parsear
     * @return \Jenssegers\Date\Date
     */
    protected function getDateInstance($value)
    {
        return Date::make($value);
    }

    /**
     * Cuando se pide la fecha de updated_at se devuelve una
     * instancia de Date en vez de Carbon\Carbon
     * @param string $value
     * @return \Jenssegers\Date\Date
     */
    public function getUpdatedAtAttribute($value)
    {
        return $this->getDateInstance($value);
    }

    /**
     * Busca al usuario que creo a este modelo.
     * @return User
     */
    public function createdBy()
    {
        return $this->findModelManipulator('created_by');
    }

    /**
     * Devuelve un usuario segun el atributo especificado del modelo.
     * @param string $key
     * @return User
     */
    protected function findModelManipulator($key)
    {
        if (isset($this->attributes[$key])) {
            $user = User::find($this->attributes[$key]);

            if ($user) {
                return $user;
            }
        }

        return User::newInstance();
    }

    /**
     * Busca al ultimo usuario que actualizo este modelo.
     * @return User
     */
    public function updatedBy()
    {
        return $this->findModelManipulator('updated_by');
    }
}
