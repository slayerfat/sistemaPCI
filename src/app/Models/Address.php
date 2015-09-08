<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;

/**
 * PCI\Models\Address
 *
 * @property integer $id
 * @property integer $parish_id
 * @property string $building
 * @property string $street
 * @property string $av
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read Parish $parish
 * @property-read \Illuminate\Database\Eloquent\Collection|Employee[] $employee
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Address whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Address whereParishId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Address whereBuilding($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Address whereStreet($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Address whereAv($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Address whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Address whereUpdatedBy($value)
 */
class Address extends AbstractBaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'building',
        'street',
        'av',
    ];

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // Belongs To 1..* -> 1
    // -------------------------------------------------------------------------

    /**
     * @return Parish
     */
    public function parish()
    {
        return $this->belongsTo(Parish::class);
    }

    // -------------------------------------------------------------------------
    // Has Many 1 -> 1..*
    // -------------------------------------------------------------------------

    /**
     * @return Collection
     */
    public function employee()
    {
        return $this->hasMany(Employee::class);
    }
}
