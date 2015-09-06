<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Town extends Model
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
     * @return State
     */
    public function state()
    {
        return $this->BelongsTo(State::class);
    }

    // -------------------------------------------------------------------------
    // Has Many 1 -> 1..*
    // -------------------------------------------------------------------------

    /**
     * @return Collection
     */
    public function parishes()
    {
        return $this->hasMany(Parish::class);
    }
}
