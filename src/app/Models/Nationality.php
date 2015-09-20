<?php

namespace PCI\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Collection;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\Nationality
 *
 * @property integer $id
 * @property string $desc
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|Employee[] $employee
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Nationality whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Nationality whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Nationality whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Nationality whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Nationality whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Nationality whereUpdatedBy($value)
 * @property string $slug
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Nationality whereSlug($value)
 */
class Nationality extends AbstractBaseModel implements SluggableInterface
{

    use SluggableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['desc'];

    /**
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
     * @return Collection
     */
    public function employee()
    {
        return $this->hasMany(Employee::class);
    }
}
