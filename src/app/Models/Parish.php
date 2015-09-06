<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Parish extends Model
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
    // Belongs To 1..* -> 1
    // -------------------------------------------------------------------------

    /**
     * @return Town
     */
    public function town()
    {
        return $this->BelongsTo(Town::class);
    }

    // -------------------------------------------------------------------------
    // Has Many 1 -> 1..*
    // -------------------------------------------------------------------------

    /**
     * @return Collection
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
