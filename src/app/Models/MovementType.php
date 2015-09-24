<?php

namespace PCI\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Collection;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\MovementType
 * @package PCI\Models
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 * @property integer $id
 * @property string $desc
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|Movement[] $movements
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\MovementType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\MovementType whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\MovementType whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\MovementType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\MovementType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\MovementType whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\MovementType whereUpdatedBy($value)
 */
class MovementType extends AbstractBaseModel implements SluggableInterface
{

    use SluggableTrait;

    /**
     * The attributes that are mass assignable.
     *
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

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // Has Many 1 -> 1..*
    // -------------------------------------------------------------------------

    /**
     * Regresa una coleccion de movimientos asociados.
     * @return Collection
     */
    public function movements()
    {
        return $this->hasMany(Movement::class);
    }
}
