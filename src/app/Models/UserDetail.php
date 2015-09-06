<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * PCI\Models\UserDetail
 *
 * @property-read User $user
 */
class UserDetail extends Model
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
     * @return User
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * @return WorkDetail
     */
    public function workDetails()
    {
        return $this->hasOne(WorkDetail::class);
    }

    // -------------------------------------------------------------------------
    // Belongs to 1..* -> 1
    // -------------------------------------------------------------------------

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
}
