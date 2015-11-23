<?php namespace PCI\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Collection;
use PCI\Models\Traits\HasSlugUID;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\MovementType
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
 * @property-read \Illuminate\Database\Eloquent\Collection|Movement[] $movements
 * @property-read \Illuminate\Database\Eloquent\Collection|NoteType[] $noteTypes
 * @property-read \Illuminate\Database\Eloquent\Collection|PetitionType[] $petitionTypes
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\MovementType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\MovementType whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\MovementType whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\MovementType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\MovementType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\MovementType whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\MovementType whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\MovementType in()
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\MovementType out()
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\MovementType unknown()
 */
class MovementType extends AbstractBaseModel implements SluggableInterface
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
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIn($query)
    {
        return $query->where('desc', 'Entrada');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOut($query)
    {
        return $query->where('desc', 'Salida');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnknown($query)
    {
        return $query->where('desc', 'Otro');
    }

    /**
     * Regresa una coleccion de movimientos asociados.
     *
     * @return Collection
     */
    public function movements()
    {
        return $this->hasMany(Movement::class);
    }

    /**
     * Regresa una coleccion de notas asociadas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function noteTypes()
    {
        return $this->hasMany(NoteType::class);
    }

    /**
     * Regresa una coleccion de notas asociadas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function petitionTypes()
    {
        return $this->hasMany(PetitionType::class);
    }

    /**
     * Determina si el tipo de movimiento es de salida
     *
     * @return bool
     */
    public function isOut()
    {
        $result = self::out()->first();

        if (is_null($result)) {
            throw new \LogicException('No existe movimiento de tipo salida');
        }

        return $result->id == $this->id;
    }

    /**
     * Determina si el tipo de movimiento es de entrada
     *
     * @return bool
     */
    public function isIn()
    {
        $result = self::in()->first();

        if (is_null($result)) {
            throw new \LogicException('No existe movimiento de tipo entrada');
        }

        return $result->id == $this->id;
    }
}
