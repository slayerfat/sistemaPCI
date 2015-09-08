<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;

/**
 * PCI\Models\Category
 *
 * @property integer $id
 * @property string $desc
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|SubCategory[] $subCategories
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Category whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Category whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Category whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Category whereUpdatedBy($value)
 */
class Category extends AbstractBaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['desc'];

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // Has Many 1 -> 1..*
    // -------------------------------------------------------------------------

    /**
     * @return Collection
     */
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
