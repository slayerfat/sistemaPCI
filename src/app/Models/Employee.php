<?php

namespace PCI\Models;

/**
 * PCI\Models\Employee
 *
 * @property-read User $user
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
        'cellphone'
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
}
