<?php

namespace PCI\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Collection;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\PetitionType

 * @property integer $id
 * @property string $desc
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|Petition[] $petitions
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\PetitionType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\PetitionType whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\PetitionType whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\PetitionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\PetitionType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\PetitionType whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\PetitionType whereUpdatedBy($value)
 */
class PetitionType extends AbstractBaseModel implements SluggableInterface
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
    public function petitions()
    {
        return $this->hasMany(Petition::class);
    }
}
