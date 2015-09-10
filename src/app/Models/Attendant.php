<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\Attendant
 *
 * @property integer $id
 * @property integer $user_id
 * @property \Carbon\Carbon $selection
 * @property boolean $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|Note[] $notes
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Attendant whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Attendant whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Attendant whereSelection($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Attendant whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Attendant whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Attendant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Attendant whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Attendant whereUpdatedBy($value)
 */
class Attendant extends AbstractBaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'selection',
        'status'
    ];

    /**
     * Atributos que deben ser mutados a dates.
     * dates se refiere a Carbon\Carbon dates.
     * En otras palabras, genera una instancia
     * de Carbon\Carbon para cada campo.
     *
     * @var array
     */
    protected $dates = ['selection'];

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // belongs to
    // -------------------------------------------------------------------------

    /**
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // -------------------------------------------------------------------------
    // has Many
    // -------------------------------------------------------------------------

    /**
     * @return Collection
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
