<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
