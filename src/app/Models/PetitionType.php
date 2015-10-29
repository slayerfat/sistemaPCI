<?php namespace PCI\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\PetitionType
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
 * @property-read \Illuminate\Database\Eloquent\Collection|Petition[] $petitions
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\PetitionType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\PetitionType whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\PetitionType whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\PetitionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\PetitionType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\PetitionType whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\PetitionType whereUpdatedBy($value)
 */
class PetitionType extends AbstractBaseModel implements SluggableInterface
{

    use SluggableTrait;

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
     * Regresa una el tipo de pedido.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function petitions()
    {
        return $this->hasMany(Petition::class);
    }

    /**
     * Regresa el tipo de movimiento asociado asociadas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function movementType()
    {
        return $this->belongsTo(MovementType::class);
    }
}
