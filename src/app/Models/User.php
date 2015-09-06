<?php

namespace PCI\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * PCI\Models\User
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\User whereUpdatedAt($value)
 * @property-read UserDetail $details
 */
class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'status'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // Has one 1 -> 1
    // -------------------------------------------------------------------------

    /**
     * @return UserDetail
     */
    public function details()
    {
        return $this->hasOne(UserDetail::class);
    }
}
