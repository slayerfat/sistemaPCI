<?php namespace PCI\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\SubCategory
 *
 * @package PCI\Models
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 * @property integer $id
 * @property integer $category_id
 * @property string $desc
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|Item[] $items
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\SubCategory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\SubCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\SubCategory whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\SubCategory whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\SubCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\SubCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\SubCategory whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\SubCategory whereUpdatedBy($value)
 */
class SubCategory extends AbstractBaseModel implements SluggableInterface
{

    use SluggableTrait;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['desc'];

    /**
     * Los datos necesarios para generarar un slug en el modelo.
     * @var array
     */
    protected $sluggable = [
        'build_from' => 'desc',
        'save_to'    => 'slug',
    ];

    /**
     * Regresa la categoria asociada al rubro.
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Regresa una coleccion de items asociados.
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
