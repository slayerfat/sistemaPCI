<?php namespace PCI\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\ItemType
 *
 * @package PCI\Models
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 * @property integer $id
 * @property string $desc
 * @property string $slug
 * @property boolean $perishable
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|Item[] $items
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\ItemType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\ItemType whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\ItemType whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\ItemType wherePerishable($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\ItemType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\ItemType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\ItemType whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\ItemType whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\ItemType perishable()
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\ItemType notPerishable()
 */
class ItemType extends AbstractBaseModel implements SluggableInterface
{

    use SluggableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['desc', 'perishable'];

    /**
     * Los datos necesarios para generarar un slug en el modelo.
     *
     * @var array
     */
    protected $sluggable = [
        'build_from' => 'desc',
        'save_to'    => 'slug',
    ];

    public function getPerishableAttribute($value)
    {
        if (is_bool($value)) {
            return $value;
        }

        return $value == "0" ? false : true;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePerishable($query)
    {
        return $query->where('perishable', true);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotPerishable($query)
    {
        return $query->where('perishable', false);
    }

    /**
     * Regresa una coleccion de items asociados.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
