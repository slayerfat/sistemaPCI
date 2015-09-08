<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * PCI\Models\NoteType
 *
 * @property integer $id
 * @property string $desc
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|Note[] $notes
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\NoteType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\NoteType whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\NoteType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\NoteType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\NoteType whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\NoteType whereUpdatedBy($value)
 */
class NoteType extends AbstractBaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['desc'];

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // Has Many 1 -> 1..*
    // -------------------------------------------------------------------------

    /**
     * @return Collection
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
