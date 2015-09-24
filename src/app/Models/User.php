<?php

namespace PCI\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\Authorizable;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\User

 * @property integer $id
 * @property integer $profile_id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $confirmation_code
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read Address $address
 * @property-read Employee $employee
 * @property-read Attendant $attendant
 * @property-read \Illuminate\Database\Eloquent\Collection|Note[] $notes
 * @property-read \Illuminate\Database\Eloquent\Collection|Petition[] $petitions
 * @property-read Profile $profile
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\User whereProfileId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\User whereConfirmationCode($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\User whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\User whereUpdatedBy($value)
 */
class User extends AbstractBaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * Administrador del sistema
     * @var int
     */
    const ADMIN_ID = Profile::ADMIN_ID;

    /**
     * Usuario del sistema
     * @var int
     */
    const USER_ID = Profile::USER_ID;

    /**
     * Usuario desactivado
     * @var int
     */
    const DISABLED_ID = Profile::DISABLED_ID;

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
    protected $fillable = ['name', 'email', 'password', 'status', 'confirmation_code'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'confirmation_code'];

    // -------------------------------------------------------------------------
    // Accessor
    // -------------------------------------------------------------------------

    /**
     * @return \PCI\Models\Address
     */
    public function getAddressAttribute()
    {
        return $this->employee->address;
    }

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // Has one 1 -> 1
    // -------------------------------------------------------------------------

    /**
     * @return Employee
     */
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    /**
     * @return Attendant
     */
    public function attendant()
    {
        return $this->hasOne(Attendant::class);
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

    /**
     * @return Collection
     */
    public function petitions()
    {
        return $this->hasMany(Petition::class);
    }

    // -------------------------------------------------------------------------
    // belongs to 1..* -> 1
    // -------------------------------------------------------------------------

    /**
     * @return Employee
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * @return boolean
     */
    public function isUser()
    {
        return $this->attributes['profile_id'] == self::USER_ID;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return !$this->isDisabled();
    }

    /**
     * @return boolean
     */
    public function isDisabled()
    {
        return $this->attributes['profile_id'] == self::DISABLED_ID;
    }

    /**
     * @return boolean
     */
    public function isUnverified()
    {
        return !$this->isVerified();
    }

    /**
     * @return boolean
     */
    public function isVerified()
    {
        return ! $this->confirmation_code;
    }

    /**
     * helper para ver si es admin o si puede manipular algun recurso.
     * @param int $id el foreign key del recurso.
     * @return boolean
     */
    public function isOwnerOrAdmin($id)
    {
        return $this->isAdmin() || $this->isOwner($id);
    }

    /**
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->attributes['profile_id'] == self::ADMIN_ID;
    }

    /**
     * chequea si el id del foreign key del recurso es igual al id del usuario,
     * en otras palabras, verific que el usuario pueda modificar algun recurso
     * viendo si le pertenece o no.
     * @param int $id el foreign key del recurso.
     * @return boolean
     */
    public function isOwner($id)
    {
        if (is_null($id)) {
            return false;
        }

        if (isset($this->attributes['id'])) {
            return $this->attributes['id'] == $id;
        }

        return false;
    }
}
