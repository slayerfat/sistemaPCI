<?php namespace PCI\Models;

use Auth;
use Eloquent;

class AbstractBaseModel extends Eloquent
{

    /**
     * Automaticamente manipula los campos de control
     * created/update
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $id = Auth::id();

            $model->created_by = $id;
            $model->updated_by = $id;
        });

        static::updating(function ($model) {
            $id = Auth::id();
            $model->updated_by = $id;
        });
    }
}
