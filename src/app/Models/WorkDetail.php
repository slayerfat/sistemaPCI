<?php namespace PCI\Models;

    /** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\WorkDetail
 *
 * @package PCI\Models
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 * @property integer $id
 * @property integer $department_id
 * @property integer $position_id
 * @property integer $employee_id
 * @property \Carbon\Carbon $join_date
 * @property \Carbon\Carbon $departure_date
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read Employee $employee
 * @property-read Position $position
 * @property-read Department $department
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\WorkDetail whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\WorkDetail whereDepartmentId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\WorkDetail wherePositionId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\WorkDetail whereEmployeeId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\WorkDetail whereJoinDate($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\WorkDetail whereDepartureDate($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\WorkDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\WorkDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\WorkDetail whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\WorkDetail whereUpdatedBy($value)
 */
class WorkDetail extends AbstractBaseModel
{

    /**
     * The attributes that are mass assignable.
     * el caso de departamento y cargo, no hay problema.
     * @var array
     */
    protected $fillable = [
        'department_id',
        'position_id',
        'join_date',
        'departure_date'
    ];

    /**
     * Atributos que deben ser mutados a dates.
     * dates se refiere a Carbon\Carbon dates.
     * En otras palabras, genera una instancia
     * de Carbon\Carbon para cada campo.
     * @var array
     */
    protected $dates = ['join_date', 'departure_date'];

    /**
     * Cuando se pide la fecha de join_date se devuelve una
     * instancia de Date en vez de Carbon\Carbon
     * @param string $value
     * @return \Jenssegers\Date\Date
     */
    public function getJoinDateAttribute($value)
    {
        return $this->getDateInstance($value);
    }

    /**
     * Cuando se pide la fecha de departure_date se devuelve una
     * instancia de Date en vez de Carbon\Carbon
     * @param string $value
     * @return \Jenssegers\Date\Date
     */
    public function getDepartureDateAttribute($value)
    {
        return $this->getDateInstance($value);
    }

    /**
     * Regresa al empleado relacionado.
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Regresa el cargo relacionado.
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Regresa el departamento relacionado.
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
