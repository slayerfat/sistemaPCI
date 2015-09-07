<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;
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
     * @return Employee
     */
    public function owner()
    {
        return $this->belongsTo(Employee::class);
    }

    // -------------------------------------------------------------------------
    // Belongs to many
    // -------------------------------------------------------------------------

    /**
     * @return Collection
     */
    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
}
