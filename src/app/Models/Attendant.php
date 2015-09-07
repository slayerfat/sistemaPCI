<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Model;

class Attendant extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'selection',
        'status'
    ];

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // belongs to
    // -------------------------------------------------------------------------

    /**
     * @return Employee
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
