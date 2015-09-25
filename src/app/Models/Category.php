<?php

namespace PCI\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Collection;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\Category
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
 * @property-read \Illuminate\Database\Eloquent\Collection|SubCategory[] $subCategories
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Category whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Category whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Category whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Category whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Category whereUpdatedBy($value)
 */
class Category extends AbstractBaseModel implements SluggableInterface
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
     * Regresa una coleccion de rubros.
     * @return Collection
     */
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
