<?php namespace PCI\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\Nationality
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
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Nationality whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Nationality whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Nationality whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Nationality whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Nationality whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Nationality whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Nationality whereUpdatedBy($value)
 */
class Nationality extends AbstractBaseModel implements SluggableInterface
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
     * Regresa una coleccion de empleados asociados.
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function employee()
    {
        return $this->hasMany(Employee::class);
    }
}
