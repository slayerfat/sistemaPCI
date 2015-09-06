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

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // Has one 1 -> 1
    // -------------------------------------------------------------------------

    /**
     * @return UserDetail
     */
    public function userDetails()
    {
        return $this->hasOne(UserDetail::class);
    }

    // -------------------------------------------------------------------------
    // Belongs to 1..* -> 1
    // -------------------------------------------------------------------------

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
