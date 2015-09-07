<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['creation'];

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
     * @return MovementType
     */
    public function type()
    {
        return $this->belongsTo(MovementType::class);
    }

    /**
     * @return Note
     */
    public function note()
    {
        return $this->belongsTo(Note::class);
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
}
