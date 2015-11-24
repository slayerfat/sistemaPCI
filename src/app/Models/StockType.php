<?php namespace PCI\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use PCI\Models\Traits\HasSlugUID;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\StockType
 *
 * @package PCI\Models
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 * @property integer $id
 * @property string $desc
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\PCI\Models\Item[] $items
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\StockType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\StockType whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\StockType whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\StockType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\StockType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\StockType whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\StockType whereUpdatedBy($value)
 */
class StockType extends AbstractBaseModel implements SluggableInterface
{

    use SluggableTrait, HasSlugUID;

    /**
     * El id en la base de datos de gramos
     */
    const GRAM_ID = 2;

    /**
     * El id en la base de datos de kilos
     */
    const KILO_ID = 3;

    /**
     * El id en la base de datos de toneladas
     */
    const TON_ID = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['desc'];

    /**
     * Los datos necesarios para generarar un slug en el modelo.
     *
     * @var array
     */
    protected $sluggable = [
        'build_from' => 'desc',
        'save_to'    => 'slug',
    ];

    /**
     * Los items que estan asociados a esta entidad.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('PCI\Models\Item');
    }

    /**
     * Los items que estan asociados a esta entidad.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stocks()
    {
        return $this->hasMany('PCI\Models\Stock');
    }

    /**
     * Los items que estan asociados a esta entidad.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itemMovements()
    {
        return $this->hasMany('PCI\Models\itemMovement');
    }
}
