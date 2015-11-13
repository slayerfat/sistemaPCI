<?php namespace PCI\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\NoteType
 *
 * @package PCI\Models
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 * @property integer $id
 * @property integer $movement_type_id
 * @property string $desc
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read MovementType $movementType
 * @property-read \Illuminate\Database\Eloquent\Collection|Note[] $notes
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\NoteType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\NoteType whereMovementTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\NoteType whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\NoteType whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\NoteType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\NoteType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\NoteType whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\NoteType whereUpdatedBy($value)
 */
class NoteType extends AbstractBaseModel implements SluggableInterface
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
     * Regresa el tipo de movimiento asociado asociadas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function movementType()
    {
        return $this->belongsTo(MovementType::class);
    }

    /**
     * Regresa una coleccion de notas asociadas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
