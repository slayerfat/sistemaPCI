<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * PCI\Models\Note
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $to_user_id
 * @property integer $attendant_id
 * @property integer $note_type_id
 * @property integer $petition_id
 * @property \Carbon\Carbon $creation
 * @property string $comments
 * @property boolean $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Petition $petition
 * @property-read User $requestedBy
 * @property-read User $toUser
 * @property-read Attendant $attendant
 * @property-read NoteType $type
 * @property-read \Illuminate\Database\Eloquent\Collection|Item[] $items
 * @property-read \Illuminate\Database\Eloquent\Collection|Movement[] $movements
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Note whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Note whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Note whereToUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Note whereAttendantId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Note whereNoteTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Note wherePetitionId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Note whereCreation($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Note whereComments($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Note whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Note whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Note whereUpdatedAt($value)
 */
class Note extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'creation',
        'comments',
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
    protected $dates = ['creation'];

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // belongs to
    // -------------------------------------------------------------------------

    /**
     * @return Petition
     */
    public function petition()
    {
        return $this->belongsTo(Petition::class);
    }

    /**
     * @return User
     */
    public function requestedBy()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return User
     */
    public function toUser()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return Attendant
     */
    public function attendant()
    {
        return $this->belongsTo(Attendant::class);
    }

    /**
     * @return NoteType
     */
    public function type()
    {
        return $this->belongsTo(NoteType::class);
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
     * @return Movement
     */
    public function movements()
    {
        return $this->hasMany(Movement::class);
    }
}
