<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Collection;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\Depot
 * @package PCI\Models
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 * @property integer $id
 * @property integer $user_id
 * @property integer $number
 * @property integer $rack
 * @property integer $shelf
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read User $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|Item[] $items
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Depot whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Depot whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Depot whereRack($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Depot whereShelf($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Depot whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Depot whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Depot whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Depot whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Depot whereNumber($value)
 */
class Depot extends AbstractBaseModel
{

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'number',
        'rack',
        'shelf'
    ];

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // Belongs to 1..* -> 1
    // -------------------------------------------------------------------------

    /**
     * Regresa al Empleado relacionado, El jefe de almacen.
     * @return User
     */
    public function owner()
    {
        // por alguna razon el user id no estaba
        // siendo tomado correctamente.
        return $this->belongsTo(User::class, 'user_id');
    }

    // -------------------------------------------------------------------------
    // Belongs to many
    // -------------------------------------------------------------------------

    /**
     * Regresa una coleccion de items existentes en el almacen.
     * @see v0.3.2 #35
     * @link https://github.com/slayerfat/sistemaPCI/issues/35
     * @return Collection
     */
    public function items()
    {
        return $this->belongsToMany(Item::class)->withPivot('quantity');
    }
}
