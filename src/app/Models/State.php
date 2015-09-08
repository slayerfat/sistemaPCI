<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * PCI\Models\State
 *
 * @property integer $id
 * @property string $desc
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|Town[] $towns
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\State whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\State whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\State whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\State whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\State whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\State whereUpdatedBy($value)
 */
class State extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['desc'];

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // Has Many 1 -> 1..*
    // -------------------------------------------------------------------------

    /**
     * @return Collection
     */
    public function towns()
    {
        return $this->hasMany(Town::class);
    }
}
