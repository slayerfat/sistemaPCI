<?php namespace PCI\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use PCI\Models\Traits\HasSlugUID;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\Gender
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
 * @property-read \Illuminate\Database\Eloquent\Collection|Employee[] $employee
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Gender whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Gender whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Gender whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Gender whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Gender whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Gender whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Gender whereUpdatedBy($value)
 */
class Gender extends AbstractBaseModel implements SluggableInterface
{

    use SluggableTrait, HasSlugUID;

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
     * Regresa una coleccion de empleados.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employee()
    {
        return $this->hasMany(Employee::class);
    }
}
