<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
     * @return Employee
     */
    public function toEmployee()
    {
        return $this->belongsTo(Employee::class);
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
