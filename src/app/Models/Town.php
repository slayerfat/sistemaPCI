<?php namespace PCI\Models;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\Town
 * @package PCI\Models
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 * @property integer $id
 * @property integer $state_id
 * @property string $desc
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read State $state
 * @property-read \Illuminate\Database\Eloquent\Collection|Parish[] $parishes
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Town whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Town whereStateId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Town whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Town whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Town whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Town whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Town whereUpdatedBy($value)
 */
class Town extends AbstractPlacesModel
{

    /**
     * Regresa al estado asociado al municipio.
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Regresa una coleccion de parroquias asociadas.
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function parishes()
    {
        return $this->hasMany(Parish::class);
    }
}
