<?php namespace PCI\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\User
 *
 * @package PCI\Models
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
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
 * @property-read mixed $address
 * @property-read Employee $employee
 * @property-read Attendant $attendant
 * @property-read \Illuminate\Database\Eloquent\Collection|Note[] $notes
 * @property-read \Illuminate\Database\Eloquent\Collection|Petition[] $petitions
 * @property-read \Illuminate\Database\Eloquent\Collection|Depot[] $manages
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
     * Id del perfil Administrador del sistema
     *
     * @var int
     */
    const ADMIN_ID = Profile::ADMIN_ID;

    /**
     * Id del perfil Usuario del sistema
     *
     * @var int
     */
    const USER_ID = Profile::USER_ID;

    /**
     * Id del perfil Usuario desactivado
     *
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
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'confirmation_code',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'password',
        'remember_token',
        'confirmation_code',
    ];

    /**
     * Regresa mamarrachamente a la direccion relacionada
     * al usuario por medio del empleado.
     *
     * @return \PCI\Models\Address
     */
    public function getAddressAttribute()
    {
        return $this->employee->address;
    }

    /**
     * Regresa la informacion de empleado relacionado al usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    /**
     * Regresa informacion de encargado de almacen, si este posee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function attendant()
    {
        return $this->hasOne(Attendant::class);
    }

    /**
     * Regresa una coleccion de notas asociadas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Regresa una coleccion de pedidos asociados.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function petitions()
    {
        return $this->hasMany(Petition::class);
    }

    /**
     * Regresa una coleccion de almacenes que maneja.
     * Esta relacion se refiere al Jefe de
     * Almacen administra/maneja almacen.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function manages()
    {
        return $this->hasMany(Depot::class);
    }

    /**
     * Regresa el perfil asociado.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    /**
     * Determina si el usuario es de perfil
     * usuario activo en el sistema.
     *
     * @return boolean
     */
    public function isUser()
    {
        return $this->attributes['profile_id'] == self::USER_ID;
    }

    /**
     * Determina si el usuario no es de perfil
     * desactivado activo en el sistema.
     *
     * @return boolean
     */
    public function isActive()
    {
        return !$this->isDisabled();
    }

    /**
     * Determina si el usuario es de perfil
     * usuario activo en el sistema.
     *
     * @return boolean
     */
    public function isDisabled()
    {
        return $this->attributes['profile_id'] == self::DISABLED_ID;
    }

    /**
     * Determina si el usuario tiene codigo de
     * verificacion en el sistema, es decir,
     * No ha sido verificado.
     *
     * @return boolean
     */
    public function isUnverified()
    {
        return !$this->isVerified();
    }

    /**
     * Determina si el usuario no tiene codigo
     * de verificacion en el sistema,
     * es decir, ha sido verificado.
     *
     * @return boolean
     */
    public function isVerified()
    {
        return !$this->confirmation_code;
    }

    /**
     * helper para ver si es admin o si puede manipular algun recurso.
     *
     * @param int $id el foreign key del recurso.
     * @return boolean
     */
    public function isOwnerOrAdmin($id)
    {
        return $this->isAdmin() || $this->isOwner($id);
    }

    /**
     * Determina si el usuario es administrador del sistema.
     *
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
     *
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

    /**
     * Determina cual es el identificador que utilizara el controlador
     *
     * @return int|string
     */
    public function controllerUID()
    {
        return $this->name;
    }
}
