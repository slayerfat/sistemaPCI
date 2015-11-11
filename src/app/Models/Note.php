<?php namespace PCI\Models;

use PCI\Models\Traits\HasCommentsAttribute;
use PCI\Models\Traits\HasTernaryStatusAttribute;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\Note
 *
 * @package PCI\Models
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
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
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read Petition $petition
 * @property-read User     $user
 * @property-read User $toUser
 * @property-read Attendant $attendant
 * @property-read NoteType $type
 * @property-read \Illuminate\Database\Eloquent\Collection|Item[] $items
 * @property-read \Illuminate\Database\Eloquent\Collection|Movement[] $movements
 * @property-read mixed $formatted_status
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
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Note whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Note whereUpdatedBy($value)
 */
class Note extends AbstractBaseModel
{

    use HasTernaryStatusAttribute, HasCommentsAttribute;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'creation',
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
    protected $dates = ['creation'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = ['status' => 'boolean'];

    /**
     * Regresa la peticion relacionada a esta nota.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function petition()
    {
        return $this->belongsTo(Petition::class);
    }

    /**
     * Regresa al usuario relacionado a esta nota.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Regresa el usuario destinatario de la nota.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    /**
     * Regresa el encargado de almacen.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function attendant()
    {
        return $this->belongsTo(Attendant::class);
    }

    /**
     * Regresa una el tipo de nota relacionado.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function type()
    {
        return $this->belongsTo(NoteType::class, 'note_type_id');
    }

    /**
     * Regresa una coleccion de items asociados.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function items()
    {
        return $this->belongsToMany(Item::class)
            ->withPivot('quantity', 'stock_type_id', 'due');
    }

    /**
     * Regresa una coleccion de movimientos asociados.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function movements()
    {
        return $this->hasMany(Movement::class);
    }

    /**
     * El mensaje a mostrar ['null|true|false'] string
     *
     * @return array
     */
    public function getStatusMessage()
    {
        return [
            'null'  => 'Por entregar',
            'true'  => 'Entregado',
            'false' => 'No entregado',
        ];
    }

    /**
     * Determina si la nota es de entrada.
     *
     * @return bool
     */
    public function isMovementTypeOut()
    {
        return !$this->isMovementTypeIn();
    }

    /**
     * Determina si la nota es de entrada.
     *
     * @return bool
     */
    public function isMovementTypeIn()
    {
        return $this->type->movementType->isIn();
    }
}
