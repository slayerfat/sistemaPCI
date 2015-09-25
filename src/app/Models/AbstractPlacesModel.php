<?php namespace PCI\Models;

/**
 * PCI\Models\AbstractPlacesModel
 * @package PCI\Models
 * Por ahora esta clase sirve para declarar los atributos que
 * tiene la herencia, es usuado por el api de direcciones
 * ya que no nos interesa que regrese informacion
 * interna, como created/updated_by
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 * @property-read mixed $created_at
 * @property-read mixed $updated_at
 */
abstract class AbstractPlacesModel extends AbstractBaseModel
{

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['desc'];

    /**
     * Los campos que seran ocultados cuando el
     * modelo se convierte en array y json
     * @var string[]
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];
}
