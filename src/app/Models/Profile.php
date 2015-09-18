<?php

namespace PCI\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Collection;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\Profile
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $users
 * @property integer $id
 * @property string $desc
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Profile whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Profile whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Profile whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Profile whereUpdatedBy($value)
 * @property string $slug
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Profile whereSlug($value)
 */
class Profile extends AbstractBaseModel implements SluggableInterface
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
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
