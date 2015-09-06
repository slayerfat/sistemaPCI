<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Model;

class Depot extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rack',
        'shelf'
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
        return $this->belongsTo(Employee::class);
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
    public function dependsOn()
    {
        return $this->belongsToMany(Item::class);
    }
}
