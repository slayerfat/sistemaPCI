<?php namespace PCI\Models;

use PCI\Models\Traits\HasIdUID;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\StockDetail
 *
 * @property integer $id
 * @property integer $stock_id
 * @property float $quantity
 * @property \Carbon\Carbon $due
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read Stock $stock
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\StockDetail whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\StockDetail whereStockId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\StockDetail whereQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\StockDetail whereDue($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\StockDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\StockDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\StockDetail whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\StockDetail whereUpdatedBy($value)
 */
class StockDetail extends AbstractBaseModel
{

    use HasIdUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'due',
        'quantity'
    ];

    /**
     * Atributos que deben ser mutados a dates.
     * dates se refiere a Carbon\Carbon dates.
     *
     * @var array
     */
    protected $dates = ['due'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Builder
     */
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
