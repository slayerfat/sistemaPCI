<?php namespace PCI\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

/**
 * Class StockType
 * @package PCI\Models
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class StockType extends AbstractBaseModel implements SluggableInterface
{

    use SluggableTrait;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['desc'];

    /**
     * Los datos necesarios para generarar un slug en el modelo.
     * @var array
     */
    protected $sluggable = [
        'build_from' => 'desc',
        'save_to'    => 'slug',
    ];

}
