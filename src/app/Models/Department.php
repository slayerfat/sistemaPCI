<?php namespace PCI\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\Department
 *
 * @package PCI\Models
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 * @property integer $id
 * @property string $desc
 * @property string $slug
 * @property string $phone
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|WorkDetail[] $workDetails
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Department whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Department whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Department whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Department wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Department whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Department whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Department whereUpdatedBy($value)
 */
class Department extends AbstractBaseModel implements SluggableInterface
{

    use SluggableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['desc', 'phone'];

    /**
     * Los datos necesarios para generarar un slug en el modelo.
     *
     * @var array
     */
    protected $sluggable = [
        'build_from' => 'desc',
        'save_to'    => 'slug',
    ];

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // Has Many 1 -> 1..*
    // -------------------------------------------------------------------------

    /**
     * Regresa una coleccion de datos laborales.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workDetails()
    {
        return $this->hasMany(WorkDetail::class);
    }
}
