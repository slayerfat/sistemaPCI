<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\Maker
 *
 * @property integer $id
 * @property string $desc
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|Item[] $items
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Maker whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Maker whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Maker whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Maker whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Maker whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Maker whereUpdatedBy($value)
 */
class Maker extends AbstractBaseModel
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
    // Has Many
    // -------------------------------------------------------------------------

    /**
     * @return Collection
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
