<?php namespace PCI\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use ICanBoogie\Inflector;
use Illuminate\Database\Eloquent\SoftDeletes;
use PCI\Mamarrachismo\Converter\interfaces\StockTypeConverterInterface;
use PCI\Mamarrachismo\Converter\StockTypeConverter;
use PCI\Models\Traits\HasSlugUID;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\Item
 *
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
 * @property float   $reserved
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read \PCI\Models\SubCategory $subCategory
 * @property-read \PCI\Models\Maker $maker
 * @property-read \PCI\Models\ItemType $type
 * @property-read \PCI\Models\StockType $stockType
 * @property-read \Illuminate\Database\Eloquent\Collection|Item[] $dependsOn
 * @property-read \Illuminate\Database\Eloquent\Collection|\PCI\Models\Petition[] $petitions
 * @property-read \Illuminate\Database\Eloquent\Collection|\PCI\Models\ItemMovement[] $movements
 * @property-read \Illuminate\Database\Eloquent\Collection|\PCI\Models\Note[] $notes
 * @property-read \Illuminate\Database\Eloquent\Collection|\PCI\Models\Depot[] $depots
 * @property-read \Illuminate\Database\Eloquent\Collection|\PCI\Models\Stock[] $stocks
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
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereReserved($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereUpdatedBy($value)
 */
class Item extends AbstractBaseModel implements SluggableInterface
{

    use SluggableTrait, SoftDeletes, HasSlugUID;

    /**
     * The attributes that are mass assignable.
     * fabricante, y demas es ok.
     *
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
    ];

    /**
     * Atributos que deben ser ocultos en array/json
     *
     * @var array
     */
    protected $hidden = [
        'asoc',
        'priority',
        'minimum',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    /**
     * Los datos necesarios para generar un slug en el modelo.
     *
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
     *
     * @var array
     */
    protected $dates = ['due', 'deleted_at'];

    /**
     * Regresa el rubro asociado al item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function subCategory()
    {
        return $this->belongsTo('PCI\Models\SubCategory');
    }

    /**
     * regresa el fabricante asociado.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function maker()
    {
        return $this->belongsTo('PCI\Models\Maker');
    }

    /**
     * Regresa el tipo de item.
     *
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
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function stockType()
    {
        return $this->belongsTo('PCI\Models\StockType', 'stock_type_id');
    }

    /**
     * Relacion unaria.
     * Regresa los items que dependen de otros items.
     *
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
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function petitions()
    {
        return $this->belongsToMany('PCI\Models\Petition')->withPivot('quantity', 'stock_type_id');
    }

    /**
     * Regresa una coleccion de movimientos relacionadas con el item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function movements()
    {
        return $this->hasMany('PCI\Models\ItemMovement');
    }

    /**
     * Regresa una coleccion de notas asociadas al item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function notes()
    {
        return $this->belongsToMany('PCI\Models\Note')
            ->withPivot('quantity', 'stock_type_id', 'due');
    }

    /**
     * Regresa el porcentaje entre el stock y el stock minimo.
     *
     * @return float
     */
    public function percentageStock()
    {
        return ceil(($this->stock() * 100) / $this->minimum);
    }

    /**
     * Regresa el stock existente tomando en cuenta
     * la cantidad ya reservada por los usuarios.
     *
     * @return float
     */
    public function stock()
    {
        $reserved = $this->reserved < 0 ? 0 : $this->reserved;

        return $this->generateStock() - floatval($reserved);
    }

    /**
     * Busca en la base de datos y regresa la sumatoria
     * de los movimientos del item en los almacenes.
     *
     * @return float la suma de las cantidades en los almacenes.
     */
    public function generateStock()
    {
        $converter = new StockTypeConverter($this);

        if ($converter->isConvertible()) {
            return $this->convertStock($converter);
        }

        // si el stock no es convertible, entonces se devuelve
        // la suma del stock en todos los almacenes.
        $i = 0;
        foreach ($this->stocks as $stock) {
            $i += $stock->details->sum('quantity');
        }

        return $i;
    }

    /**
     * convierte el stock de diferentes tipos compatibles
     * existente dentro de los almacenes.
     *
     * @param StockTypeConverterInterface $converter
     * @return float
     */
    protected function convertStock(StockTypeConverterInterface $converter)
    {
        $amount  = 0;

        foreach ($this->stocks as $stock) {
            foreach ($stock->details as $details) {
                $amount += $converter->convert(
                    $stock->stock_type_id,
                    $details->quantity
                );
            }
        }

        return $amount;
    }

    /**
     * Regresa una coleccion de almacenes en donde este item puede estar.
     *
     * @see  v0.3.2 #35
     * @link https://github.com/slayerfat/sistemaPCI/issues/35
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function depots()
    {
        return $this->belongsToMany('PCI\Models\Depot')
            ->withPivot('quantity', 'stock_type_id');
    }

    /**
     * La serie de stock existente en los almacenes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function stocks()
    {
        return $this->hasMany('PCI\Models\Stock');
    }

    /**
     * Regresa el porcentaje entre el stock y el stock minimo.
     *
     * @return float
     */
    public function percentageReserved()
    {
        $stock = $this->realStock() <= 0 ? 1 : $this->realStock();

        $reserved = floatval($this->reserved);

        return ceil(($reserved * 100) / $stock);
    }

    /**
     * Regresa el stock existente sin tomar en cuenta
     * la cantidad ya reservada por los usuarios.
     *
     * @return float
     */
    public function realStock()
    {
        return $this->generateStock();
    }

    /**
     * Regresa la cantidad o stock existente del
     * item en formato legible para el usuario.
     *
     * @return string si el item tiene 1, entonces 1 Unidad.
     */
    public function formattedStock()
    {
        $stock = $this->stock();

        return $this->generateFormatted($stock);
    }

    /**
     * @param $stock
     * @return string
     */
    private function generateFormatted($stock)
    {
        $stock = $this->checkFloat($stock);

        return $this->formattedQuantity($stock);
    }

    /**
     * Chequea que numero sea apropiado.
     * de 1.00 -> 1.
     *
     * @param $number
     * @return int
     */
    private function checkFloat($number)
    {
        if ($number == floor($number)) {
            $number = (int)$number;

            return $number;
        }

        return $number;
    }

    /**
     * Genera un string con el tipo de cantidad en plural o singular.
     * Solucion mamarracha.
     *
     * @param int         $number el stock del item
     * @param string|null $type   el tipo de stock
     * @return string si el item tiene 1, entonces 1 Unidad.
     */
    public function formattedQuantity($number, $type = null)
    {
        $type = $type ? $type : $this->stockType->desc;

        $number = $this->checkFloat($number);

        // como usualmente se dice cero unidades,
        // entonces tambien se pluraliza.
        if ($number == 1) {
            return $number . ' ' . $type;
        }

        return $number . ' ' . Inflector::get('es')
            ->pluralize($type);
    }

    /**
     * Regresa la cantidad o stock existente del
     * item en formato legible para el usuario.
     *
     * @return string si el item tiene 1, entonces 1 Unidad.
     */
    public function formattedReserved()
    {
        return $this->generateFormatted($this->reserved);
    }

    /**
     * Regresa la cantidad o stock existente del
     * item en formato legible para el usuario.
     *
     * @return string si el item tiene 1, entonces 1 Unidad.
     */
    public function formattedRealStock()
    {
        $stock = $this->realStock();

        return $this->generateFormatted($stock);
    }
}
