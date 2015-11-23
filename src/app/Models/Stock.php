<?php namespace PCI\Models;

use PCI\Models\Traits\HasIdUID;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\Stock
 *
 * @property integer $id
 * @property integer $depot_id
 * @property integer $item_id
 * @property integer $stock_type_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read StockType $type
 * @property-read Depot $depot
 * @property-read Item $item
 * @property-read \Illuminate\Database\Eloquent\Collection|StockDetail[] $details
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Stock whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Stock whereDepotId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Stock whereItemId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Stock whereStockTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Stock whereTotal($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Stock whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Stock whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Stock whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Stock whereUpdatedBy($value)
 */
class Stock extends AbstractBaseModel
{

    use HasIdUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|\Illuminate\Database\Eloquent\Builder
     */
    public function type()
    {
        return $this->belongsTo(StockType::class, 'stock_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|\Illuminate\Database\Eloquent\Builder
     */
    public function depot()
    {
        return $this->belongsTo(Depot::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Builder
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function details()
    {
        return $this->hasMany(StockDetail::class);
    }
}
