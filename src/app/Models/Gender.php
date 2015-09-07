<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
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
    public function employee()
    {
        return $this->hasMany(Employee::class);
    }
}
