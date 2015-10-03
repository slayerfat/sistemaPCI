<?php namespace PCI\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\Item
 * @package PCI\Models
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 * @property integer $id
 * @property integer $item_type_id
 * @property integer $maker_id
 * @property integer $stock_type_id
 * @property integer $sub_category_id
 * @property string $asoc
 * @property integer $priority
 * @property string $desc
 * @property string $slug
 * @property integer $minimum
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read mixed $stock
 * @property-read \Illuminate\Database\Eloquent\Collection|\PCI\Models\Depot[] $depots
 * @property-read \PCI\Models\SubCategory $subCategory
 * @property-read \PCI\Models\Maker $maker
 * @property-read \PCI\Models\ItemType $type
 * @property-read \PCI\Models\StockType $stockType
 * @property-read \Illuminate\Database\Eloquent\Collection|Item[] $dependsOn
 * @property-read \Illuminate\Database\Eloquent\Collection|\PCI\Models\Petition[] $petitions
 * @property-read \Illuminate\Database\Eloquent\Collection|\PCI\Models\Movement[] $movements
 * @property-read \Illuminate\Database\Eloquent\Collection|\PCI\Models\Note[] $notes
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereItemTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereMakerId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereStockTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereSubCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereAsoc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item wherePriority($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereMinimum($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereUpdatedBy($value)
 */
class Item extends AbstractBaseModel implements SluggableInterface
{

    use SluggableTrait;

    /**
     * The attributes that are mass assignable.
     * fabricante, y demas es ok.
     * @var array
     */
    protected $fillable = [
        'maker_id',
        'sub_category_id',
        'item_type_id',
        'stock_type_id',
        'asoc',
        'priority',
        'desc',
        'minimum',
        'due',
    ];

    /**
     * Los datos necesarios para generarar un slug en el modelo.
     * @var array
     */
    protected $sluggable = [
        'build_from' => 'desc',
        'save_to'    => 'slug',
    ];

    /**
     * Atributos que deben ser mutados a dates.
     * dates se refiere a Carbon\Carbon dates.
     * En otras palabras, genera una instancia
     * de Carbon\Carbon para cada campo.
     * @var array
     */
    protected $dates = ['due'];

    /**
     * Regresa el stock (cantidad total) en
     * el inventario de este item.
     * @return int
     */
    public function getStockAttribute()
    {
        return $this->stock();
    }

    /**
     * Busca en la base de datos y regresa la sumatoria
     * de los movimientos del item en los almacenes.
     * @return int la suma de las cantidades en los almacenes.
     */
    public function stock()
    {
        return $this->attributes['stock'] = $this->depots()
                                                 ->withPivot('quantity')
                                                 ->sum('quantity');
    }

    /**
     * Regresa una coleccion de almacenes en donde este item puede estar.
     * @see v0.3.2 #35
     * @link https://github.com/slayerfat/sistemaPCI/issues/35
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function depots()
    {
        return $this->belongsToMany('PCI\Models\Depot')->withPivot('quantity');
    }

    /**
     * Regresa el rubro asociado al item.
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function subCategory()
    {
        return $this->belongsTo('PCI\Models\SubCategory');
    }

    /**
     * regresa el fabricante asociado.
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function maker()
    {
        return $this->belongsTo('PCI\Models\Maker');
    }

    /**
     * Regresa el tipo de item.
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function type()
    {
        // otra vez por alguna razon el item type id
        // no queria ser reconocido, investigar.
        return $this->belongsTo('PCI\Models\ItemType', 'item_type_id');
    }

    /**
     * Regresa el tipo de item.
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function stockType()
    {
        return $this->belongsTo('PCI\Models\StockType', 'item_type_id');
    }

    /**
     * Relacion unaria.
     * Regresa los items que dependen de otros items.
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function dependsOn()
    {
        return $this->belongsToMany(
            self::class,
            'item_item',
            'item_id',
            'depends_on_id'
        );
    }

    /**
     * Regresa una coleccion de peticiones relacionadas con el item.
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function petitions()
    {
        return $this->belongsToMany('PCI\Models\Petition')->withPivot('quantity');
    }

    /**
     * Regresa una coleccion de movimientos relacionadas con el item.
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function movements()
    {
        return $this->belongsToMany('PCI\Models\Movement')
                    ->withPivot('quantity', 'due');
    }

    /**
     * Regresa una coleccion de notas asociadas al item.
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function notes()
    {
        return $this->belongsToMany('PCI\Models\Note')->withPivot('quantity');
    }

    /**
     * Regresa el porcentaje entre el stock y el stock minimo.
     * @return float
     */
    public function percentageStock()
    {
        return ceil(($this->stock * 100) / $this->minimum);
    }
}
