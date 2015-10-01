<?php

namespace PCI\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Collection;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\Item
 * @package PCI\Models
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 * @property integer $id
 * @property integer $item_type_id
 * @property integer $maker_id
 * @property integer $sub_category_id
 * @property string $asoc
 * @property integer $priority
 * @property string $desc
 * @property string $slug
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\PCI\Models\Item[] $dependsOn
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
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereStock($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereMinimum($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Item whereDue($value)
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

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // Belongs to 1..* -> 1
    // -------------------------------------------------------------------------

    /**
     * Regresa el rubro asociado al item.
     * @return SubCategory
     */
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    /**
     * regresa el fabricante asociado.
     * @return Maker
     */
    public function maker()
    {
        return $this->belongsTo(Maker::class);
    }

    /**
     * Regresa el tipo de item.
     * @return ItemType
     */
    public function type()
    {
        // otra vez por alguna razon el item type id
        // no queria ser reconocido, investigar.
        return $this->belongsTo(ItemType::class, 'item_type_id');
    }

    // -------------------------------------------------------------------------
    // Belongs to many
    // -------------------------------------------------------------------------

    /**
     * Regresa una coleccion de almacenes en donde este item puede estar.
     * @see v0.3.2 #35
     * @link https://github.com/slayerfat/sistemaPCI/issues/35
     * @return Collection
     */
    public function depots()
    {
        return $this->belongsToMany(Depot::class)->withPivot('quantity');
    }

    /**
     * Relacion unaria.
     * Regresa los items que dependen de otros items.
     * @return Collection
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
     * @return Collection
     */
    public function petitions()
    {
        return $this->belongsToMany(Petition::class)->withPivot('quantity');
    }

    /**
     * Regresa una coleccion de movimientos relacionadas con el item.
     * @return Collection
     */
    public function movements()
    {
        return $this->belongsToMany(Movement::class)
                    ->withPivot('quantity', 'due');
    }

    /**
     * Regresa una coleccion de notas asociadas al item.
     * @return Collection
     */
    public function notes()
    {
        return $this->belongsToMany(Note::class)->withPivot('quantity');
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
