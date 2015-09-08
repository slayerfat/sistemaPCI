<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;

/**
 * PCI\Models\ItemType
 *
 * @property integer $id
 * @property string $desc
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|Item[] $items
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\ItemType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\ItemType whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\ItemType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\ItemType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\ItemType whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\ItemType whereUpdatedBy($value)
 */
class ItemType extends AbstractBaseModel
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
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
