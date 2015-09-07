<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * PCI\Models\Employee
 *
 * @property-read User $user
 */
class Employee extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ci',
        'first_name',
        'last_name',
        'first_surname',
        'last_surname',
        'phone',
    ];

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // Has one 1 -> 1
    // -------------------------------------------------------------------------

    /**
     * @return WorkDetail
     */
    public function workDetails()
    {
        return $this->hasOne(WorkDetail::class);
    }

    /**
     * @return Attendant
     */
    public function attendant()
    {
        return $this->hasOne(Attendant::class);
    }

    // -------------------------------------------------------------------------
    // Belongs to 1..* -> 1
    // -------------------------------------------------------------------------

    /**
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return Nationality
     */
    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }

    /**
     * @return Gender
     */
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    /**
     * @return Address
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    // -------------------------------------------------------------------------
    // has Many 1 -> 1..*
    // -------------------------------------------------------------------------

    /**
     * @return Collection
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
