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

    /**
     * @return User
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
