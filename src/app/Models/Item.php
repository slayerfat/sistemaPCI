<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asoc',
        'priority',
        'desc',
        'stock',
        'minimun',
        'due',
    ];

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // Belongs to 1..* -> 1
    // -------------------------------------------------------------------------

    /**
     * @return SubCategory
     */
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    /**
     * @return Maker
     */
    public function maker()
    {
        return $this->belongsTo(Maker::class);
    }

    /**
     * @return ItemType
     */
    public function type()
    {
        return $this->belongsTo(ItemType::class);
    }

    // -------------------------------------------------------------------------
    // Belongs to many
    // -------------------------------------------------------------------------

    /**
     * @return Collection
     */
    public function depots()
    {
        return $this->belongsToMany(Depot::class);
    }

    /**
     * Relacion unaria.
     * @return Collection
     */
    public function dependsOn()
    {
        return $this->belongsToMany(Item::class);
    }
}
