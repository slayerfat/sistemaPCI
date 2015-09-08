<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * PCI\Models\SubCategory
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $desc
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|Item[] $items
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\SubCategory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\SubCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\SubCategory whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\SubCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\SubCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\SubCategory whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\SubCategory whereUpdatedBy($value)
 */
class SubCategory extends Model
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
    // Belongs to 1..* -> 1
    // -------------------------------------------------------------------------

    /**
     * @return Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // -------------------------------------------------------------------------
    // Has Many 1 -> 1..*
    // -------------------------------------------------------------------------

    /**
     * @return Collection
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
