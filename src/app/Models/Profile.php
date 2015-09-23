<?php

namespace PCI\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Collection;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\Profile

 * @property integer $id
 * @property string $desc
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $users
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Profile whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Profile whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Profile whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Profile whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Profile whereUpdatedBy($value)
 */
class Profile extends AbstractBaseModel implements SluggableInterface
{

    use SluggableTrait;

    /**
     * Administrador del sistema
     * @var int
     */
    const ADMIN_ID    = 1;

    /**
     * Usuario del sistema
     * @var int
     */
    const USER_ID     = 2;

    /**
     * Usuario desactivado
     * @var int
     */
    const DISABLED_ID = 3;

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
