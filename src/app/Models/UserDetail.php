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
    // Has one
    // -------------------------------------------------------------------------

    /**
     * @return User
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    // -------------------------------------------------------------------------
    // Belongs to
    // -------------------------------------------------------------------------

    /**
     * @return Nationality
     */
    public function nationality()
    {
        return $this->BelongsTo(Nationality::class);
    }

    /**
     * @return Nationality
     */
    public function gender()
    {
        return $this->BelongsTo(Gender::class);
    }
}
