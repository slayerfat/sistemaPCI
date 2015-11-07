<?php namespace PCI\Models;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\Movement
 *
 * @package PCI\Models
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 * @property integer $id
 * @property integer $movement_type_id
 * @property integer $note_id
 * @property \Carbon\Carbon $creation
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read MovementType $type
 * @property-read Note $note
 * @property-read \Illuminate\Database\Eloquent\Collection|Item[] $items
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Movement whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Movement whereMovementTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Movement whereNoteId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Movement whereCreation($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Movement whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Movement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Movement whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Movement whereUpdatedBy($value)
 */
class Movement extends AbstractBaseModel
{

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['creation'];

    /**
     * Atributos que deben ser mutados a dates.
     * dates se refiere a Carbon\Carbon dates.
     * En otras palabras, genera una instancia
     * de Carbon\Carbon para cada campo.
     * @var array
     */
    protected $dates = ['creation'];

    /**
     * Regresa el tipo de movimiento relacionado.
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function type()
    {
        return $this->belongsTo(MovementType::class, 'movement_type_id');
    }

    /**
     * Regresa la nota relacionada a este movimiento.
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function note()
    {
        return $this->belongsTo(Note::class);
    }

    /**
     * Regresa una coleccion de items asociados.
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function items()
    {
        return $this->belongsToMany(Item::class)
                    ->withPivot('quantity', 'due');
    }
}
