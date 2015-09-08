<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;

/**
 * PCI\Models\Item
 *
 * @property integer $id
 * @property integer $item_type_id
 * @property integer $maker_id
 * @property integer $sub_category_id
 * @property string $asoc
 * @property integer $priority
 * @property string $desc
 * @property integer $stock
 * @property integer $minimum
 * @property \Carbon\Carbon $due
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read SubCategory $subCategory
 * @property-read Maker $maker
 * @property-read ItemType $type
 * @property-read \Illuminate\Database\Eloquent\Collection|Depot[] $depots
 * @property-read \Illuminate\Database\Eloquent\Collection|Item[] $dependsOn
 * @property-read \Illuminate\Database\Eloquent\Collection|Petition[] $petitions
 * @property-read \Illuminate\Database\Eloquent\Collection|Movement[] $movements
 * @property-read \Illuminate\Database\Eloquent\Collection|Note[] $notes
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereItemTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereMakerId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereSubCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereAsoc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item wherePriority($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereStock($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereMinimum($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereDue($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereUpdatedBy($value)
 */
class Item extends AbstractBaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asoc',
        'priority',
        'desc',
        'stock',
        'minimun',
        'due',
    ];

    /**
     * Atributos que deben ser mutados a dates.
     * dates se refiere a Carbon\Carbon dates.
     * En otras palabras, genera una instancia
     * de Carbon\Carbon para cada campo.
     *
     * @var array
     */
    protected $dates = ['due'];

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // Belongs to 1..* -> 1
    // -------------------------------------------------------------------------

    /**
     * @return SubCategory
     */
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    /**
     * @return Maker
     */
    public function maker()
    {
        return $this->belongsTo(Maker::class);
    }

    /**
     * @return ItemType
     */
    public function type()
    {
        return $this->belongsTo(ItemType::class);
    }

    // -------------------------------------------------------------------------
    // Belongs to many
    // -------------------------------------------------------------------------

    /**
     * @return Collection
     */
    public function depots()
    {
        return $this->belongsToMany(Depot::class);
    }

    /**
     * Relacion unaria.
     * @return Collection
     */
    public function dependsOn()
    {
        return $this->belongsToMany(Item::class);
    }

    /**
     * @return Collection
     */
    public function petitions()
    {
        return $this->belongsToMany(Petition::class)->withPivot('quantity');
    }

    /**
     * @return Collection
     */
    public function movements()
    {
        return $this->belongsToMany(Movement::class)->withPivot('quantity');
    }

    /**
     * @return Collection
     */
    public function notes()
    {
        return $this->belongsToMany(Note::class)->withPivot('quantity');
    }
}
