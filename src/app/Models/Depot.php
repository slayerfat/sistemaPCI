<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * PCI\Models\Depot
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $rack
 * @property integer $shelf
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read Employee $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|Item[] $items
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Depot whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Depot whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Depot whereRack($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Depot whereShelf($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Depot whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Depot whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Depot whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Depot whereUpdatedBy($value)
 */
class Depot extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rack',
        'shelf'
    ];

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // Belongs to 1..* -> 1
    // -------------------------------------------------------------------------

    /**
     * @return Employee
     */
    public function owner()
    {
        return $this->belongsTo(Employee::class);
    }

    // -------------------------------------------------------------------------
    // Belongs to many
    // -------------------------------------------------------------------------

    /**
     * @return Collection
     */
    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
}
