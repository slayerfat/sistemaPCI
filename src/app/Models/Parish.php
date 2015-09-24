<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\Parish
 * @package PCI\Models
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 * @property integer $id
 * @property integer $town_id
 * @property string $desc
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read Town $town
 * @property-read \Illuminate\Database\Eloquent\Collection|Address[] $addresses
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Parish whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Parish whereTownId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Parish whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Parish whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Parish whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Parish whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Parish whereUpdatedBy($value)
 */
class Parish extends AbstractPlacesModel
{

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // Belongs To 1..* -> 1
    // -------------------------------------------------------------------------

    /**
     * @return Town
     */
    public function town()
    {
        return $this->belongsTo(Town::class);
    }

    // -------------------------------------------------------------------------
    // Has Many 1 -> 1..*
    // -------------------------------------------------------------------------

    /**
     * @return Collection
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
