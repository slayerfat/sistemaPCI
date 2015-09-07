<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Model;

class WorkDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['join_date', 'departure_date'];

    /**
     * Atributos que deben ser mutados a dates.
     * dates se refiere a Carbon\Carbon dates.
     * En otras palabras, genera una instancia
     * de Carbon\Carbon para cada campo.
     *
     * @var array
     */
    protected $dates = ['join_date', 'departure_date'];

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // Has one 1 -> 1
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Belongs to 1..* -> 1
    // -------------------------------------------------------------------------

    /**
     * @return Employee
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * @return Position
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * @return Department
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
