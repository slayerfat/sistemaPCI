<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

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
 * @property-read mixed $formatted_details
 */
class Address extends AbstractBaseModel
{

    /**
     * The attributes that are mass assignable.
     * Parroquina no tiene problema.
     * @var array
     */
    protected $fillable = [
        'parish_id',
        'building',
        'street',
        'av',
    ];

    // -------------------------------------------------------------------------
    // Accesors
    // -------------------------------------------------------------------------

    /**
     * @return string
     */
    public function getFormattedDetailsAttribute()
    {
        $details = [];

        $details[] = $this->formattedBuilding();

        $details[] = $this->formattedStreet();

        $details[] = $this->formattedAv();

        $results = implode(', ', $details);

        if (strlen($results) < 5) {
            return '';
        }

        return $results;
    }

    /**
     * @return string|null
     */
    public function formattedBuilding()
    {
        if (!isset($this->attributes['building'])) {
            return null;
        }

        return 'Edf./Qta./Blq. ' . $this->building;
    }

    /**
     * @return string|null
     */
    public function formattedStreet()
    {
        if (!isset($this->attributes['street'])) {
            return null;
        }

        return 'Calle(s) ' . $this->street;
    }

    /**
     * @return string|null
     */
    public function formattedAv()
    {
        if (!isset($this->attributes['av'])) {
            return null;
        }

        return 'Av. ' . $this->av;
    }

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // Belongs To 1..* -> 1
    // -------------------------------------------------------------------------

    public function getBuildingAttribute($value)
    {
        $value = $this->removeDotInString($value);

        return $this->ucAndCleanString($value);
    }

    // -------------------------------------------------------------------------
    // Has Many 1 -> 1..*
    // -------------------------------------------------------------------------

    /**
     * @param $value
     * @return mixed
     */
    private function removeDotInString($value)
    {
        if ($value[strlen($value) - 1] == '.') {
            $value[strlen($value) - 1] = null;
        }

        return $value;
    }

    /**
     * @param $value
     * @return string
     */
    private function ucAndCleanString($value)
    {
        return ucfirst(trim($value));
    }

    public function getStreetAttribute($value)
    {
        $value = $this->removeDotInString($value);

        return $this->ucAndCleanString($value);
    }

    public function getAvAttribute($value)
    {
        $value = $this->removeDotInString($value);

        return $this->ucAndCleanString($value);
    }

    /**
     * @return Parish
     */
    public function parish()
    {
        return $this->belongsTo(Parish::class);
    }

    /**
     * @return Collection
     */
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }
}
