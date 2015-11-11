<?php namespace PCI\Models;

    /** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\Stock
 *
 * @package PCI\Models
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 * @property integer                                                      $id
 * @property integer                                                      $depot_id
 * @property integer                                                      $item_id
 * @property integer                                                      $stock_type_id
 * @property float                                                        $total
 * @property \Carbon\Carbon                                               $created_at
 * @property \Carbon\Carbon                                               $updated_at
 * @property integer                                                      $created_by
 * @property integer                                                      $updated_by
 * @property-read StockType                                               $type
 * @property-read Depot                                                   $depot
 * @property-read Item                                                    $item
 * @property-read \Illuminate\Database\Eloquent\Collection|ItemMovement[] $itemMovements
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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'total',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(StockType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function depot()
    {
        return $this->belongsTo(Depot::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itemMovements()
    {
        return $this->hasMany(ItemMovement::class);
    }
}
