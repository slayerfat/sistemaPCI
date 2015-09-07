<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['desc', 'phone'];

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // Has Many 1 -> 1..*
    // -------------------------------------------------------------------------

    /**
     * @return Collection
     */
    public function workDetails()
    {
        return $this->hasMany(WorkDetail::class);
    }
}
