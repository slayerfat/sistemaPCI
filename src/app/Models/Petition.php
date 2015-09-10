<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\Petition
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $petition_type_id
 * @property \Carbon\Carbon $request_date
 * @property string $comments
 * @property boolean $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read PetitionType $type
 * @property-read User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|Item[] $items
 * @property-read \Illuminate\Database\Eloquent\Collection|Note[] $notes
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Petition whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Petition whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Petition wherePetitionTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Petition whereRequestDate($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Petition whereComments($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Petition whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Petition whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Petition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Petition whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Petition whereUpdatedBy($value)
 */
class Petition extends AbstractBaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'request_date',
        'comments',
        'status',
    ];

    /**
     * Atributos que deben ser mutados a dates.
     * dates se refiere a Carbon\Carbon dates.
     * En otras palabras, genera una instancia
     * de Carbon\Carbon para cada campo.
     *
     * @var array
     */
    protected $dates = ['request_date'];

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // Has Many 1 -> 1..*
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // belongs to
    // -------------------------------------------------------------------------

    /**
     * @return PetitionType
     */
    public function type()
    {
        return $this->belongsTo(PetitionType::class);
    }

    /**
     * @return Employee
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // -------------------------------------------------------------------------
    // belongs to many
    // -------------------------------------------------------------------------

    /**
     * @return Collection
     */
    public function items()
    {
        return $this->belongsToMany(Item::class)->withPivot('quantity');
    }

    // -------------------------------------------------------------------------
    // has many
    // -------------------------------------------------------------------------

    /**
     * @return Collection
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
