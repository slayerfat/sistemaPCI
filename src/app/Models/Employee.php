<?php namespace PCI\Models;

    /** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\Employee
 *
 * @package PCI\Models
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 * @property integer $id
 * @property integer $user_id
 * @property integer $address_id
 * @property integer $nationality_id
 * @property integer $gender_id
 * @property integer $ci
 * @property string $first_name
 * @property string $last_name
 * @property string $first_surname
 * @property string $last_surname
 * @property string $phone
 * @property string $cellphone
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read WorkDetail $workDetails
 * @property-read User $user
 * @property-read Nationality $nationality
 * @property-read Gender $gender
 * @property-read Address $address
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Employee whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Employee whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Employee whereAddressId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Employee whereNationalityId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Employee whereGenderId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Employee whereCi($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Employee whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Employee whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Employee whereFirstSurname($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Employee whereLastSurname($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Employee wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Employee whereCellphone($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Employee whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Employee whereUpdatedBy($value)
 */
class Employee extends AbstractBaseModel
{

    /**
     * The attributes that are mass assignable.
     * La nacionalidad y genero no son problema.
     *
     * @var array
     */
    protected $fillable = [
        'ci',
        'nationality_id',
        'gender_id',
        'first_name',
        'last_name',
        'first_surname',
        'last_surname',
        'phone',
        'cellphone',
    ];

    // -------------------------------------------------------------------------
    // Mutators
    // -------------------------------------------------------------------------

    /**
     * Muta la cedula de identidad: si no hay cedula,
     * la convierte a nulo para que sea guardada
     * correctamente en la base de datos.
     *
     * @param int $value
     * @return null|integer
     */
    public function setCiAttribute($value)
    {
        if (is_string($value) && trim($value) == '') {
            return $this->attributes['ci'] = null;
        }

        return $this->attributes['ci'] = (int)$value;
    }

    /**
     * Regresa los datos laborales del empleado.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function workDetails()
    {
        return $this->hasOne(WorkDetail::class);
    }

    /**
     * Regresa el usuario relacionado con el empleado.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Regresa la nacionalidad relacionada con el empleado.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }

    /**
     * Regresa el genero relacionado con el empleado.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    /**
     * Regresa la direccion relacionada con el empleado.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Genera los nombres en formato legible para
     * ser consumido por alguna vista.
     *
     * @param boolean $everything chequea si se trae los nombres secundarios.
     * @return string
     */
    public function formattedNames($everything = null)
    {
        $firstName = ucfirst($this->attributes['first_name']);

        $firstSurname = ucfirst($this->attributes['first_surname']);

        // si everything no es nulo entonces
        // se desea los nombres y apellidos.
        if (is_null($everything)) {
            return "{$firstSurname}, {$firstName}";
        }

        return $this->formattedNamesWithLast($firstSurname, $firstName);
    }

    /**
     * Genera los nombres en formato legible con los nombres y apellidos.
     *
     * @param string $firstSurname El primer apellido.
     * @param string $firstName El primer nombre.
     * @return string los apellidos, nombres.
     */
    private function formattedNamesWithLast($firstSurname, $firstName)
    {
        $lastName = isset($this->attributes['last_name']) ?
            ucfirst($this->attributes['last_name']) : '';

        $lastSurName = isset($this->attributes['last_surname']) ?
            ucfirst($this->attributes['last_surname']) : '';

        $surnames = trim("{$firstSurname} {$lastSurName}");
        $names = trim("{$firstName} {$lastName}");

        return "{$surnames}, {$names}";
    }
}
