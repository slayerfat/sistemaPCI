<?php namespace PCI\Models;

class AbstractPlacesModel extends AbstractBaseModel
{

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['desc'];

    /**
     * Los campos que seran ocultados cuando el
     * modelo se convierte en array y json
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];

}
