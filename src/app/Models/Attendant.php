<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;
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

    /**
     * Atributos que deben ser mutados a dates.
     * dates se refiere a Carbon\Carbon dates.
     * En otras palabras, genera una instancia
     * de Carbon\Carbon para cada campo.
     *
     * @var array
     */
    protected $dates = ['selection'];

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

    // -------------------------------------------------------------------------
    // has Many
    // -------------------------------------------------------------------------

    /**
     * @return Collection
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
