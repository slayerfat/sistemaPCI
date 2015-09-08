<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * PCI\Models\Department
 *
 * @property integer $id
 * @property string $desc
 * @property string $phone
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|WorkDetail[] $workDetails
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Department whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Department whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Department wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Department whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Department whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Department whereUpdatedBy($value)
 */
class Department extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['desc', 'phone'];

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // Has Many 1 -> 1..*
    // -------------------------------------------------------------------------

    /**
     * @return Collection
     */
    public function workDetails()
    {
        return $this->hasMany(WorkDetail::class);
    }
}
