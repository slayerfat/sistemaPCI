<?php namespace PCI\Models;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/**
 * PCI\Models\Address
 *
 * @package PCI\Models
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 * @property integer $id
 * @property integer $parish_id
 * @property string $building
 * @property string $street
 * @property string $av
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read mixed $formatted_details
 * @property-read Parish $parish
 * @property-read Employee $employee
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Address whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Address whereParishId($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Address whereBuilding($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Address whereStreet($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Address whereAv($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Address whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\PCI\Models\Address whereUpdatedBy($value)
 */
class Address extends AbstractBaseModel
{

    /**
     * The attributes that are mass assignable.
     * Parroquina no tiene problema.
     * @var string[]
     */
    protected $fillable = [
        'parish_id',
        'building',
        'street',
        'av',
    ];

    // -------------------------------------------------------------------------
    // Accesors
    // -------------------------------------------------------------------------

    /**
     * Regresa una cadena de texto
     * formateada de forma agradable para la vista.
     * @return string
     */
    public function getFormattedDetailsAttribute()
    {
        $details = [];

        $details[] = $this->formattedBuilding();

        $details[] = $this->formattedStreet();

        $details[] = $this->formattedAv();

        $results = implode(', ', $details);

        if (strlen($results) < 5) {
            return '';
        }

        return $results;
    }

    /**
     * Regresa un string con 'Edf./Qta./Blq. {$this->building}' o nulo.
     * @return string|null
     */
    public function formattedBuilding()
    {
        $attr = $this->attributes['building'];

        return $this->isAttrValid($attr) ? 'Edf./Qta./Blq. ' . $this->building : null;
    }

    /**
     * (q . !k . !l) === !(!q + k + l)
     * @param string $attr el atributo a validar
     * @return bool
     */
    private function isAttrValid($attr)
    {
        return !(!isset($attr) || is_null($attr) || trim($attr) == '');
    }

    /**
     * Regresa un string con 'Calle(s) {$this->street}' o nulo.
     * @return string|null
     */
    public function formattedStreet()
    {
        $attr = $this->attributes['street'];

        return $this->isAttrValid($attr) ? 'Calle(s) ' . $this->street : null;
    }

    /**
     * Regresa un string con 'Av. {$this->av}' o nulo.
     * @return string|null
     */
    public function formattedAv()
    {
        $attr = $this->attributes['av'];

        return $this->isAttrValid($attr) ? 'Av. ' . $this->av : null;
    }

    /**
     * Regresa la parroquia relacionada.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parish()
    {
        return $this->belongsTo(Parish::class);
    }

    /**
     * Regresa una coleccion de empleados relacionados.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    /**
     * Regresa el edificio en formato legible.
     * @param string $value El atributo interno a devolver.
     * @return string
     */
    public function getBuildingAttribute($value)
    {
        $value = $this->removeDotInString($value);

        return $this->ucAndCleanString($value);
    }

    /**
     * Si la cadena de texto tiene un punto al final, lo elimina.
     * Esto se debe a que cuando se formatea el texto,
     * nos conviene que no tenga el punto.
     * @param string $value La cadena de texto a comprobar.
     * @return string|null
     */
    private function removeDotInString($value)
    {
        // esto evita hacer operaciones en nulo
        if (is_null($value) || trim($value) == '') {
            return null;
        }

        // si el ultimo caracter del texto es un punto
        // entonces lo pone nulo, se trato con
        // unset, pero no sirve, investigar
        // una mejor solucion para esto.
        if ($value[strlen($value) - 1] == '.') {
            $value[strlen($value) - 1] = null;
        }

        return $value;
    }

    /**
     * Devuelve la primera letra del string en mayuscula, con trim.
     * @param string $value el valor a manipular.
     * @return string
     */
    private function ucAndCleanString($value)
    {
        return ucfirst(trim($value));
    }

    /**
     * Regresa el edificio en formato legible.
     * @param string $value El atributo interno a devolver.
     * @return string
     */
    public function getStreetAttribute($value)
    {
        $value = $this->removeDotInString($value);

        return $this->ucAndCleanString($value);
    }

    /**
     * Regresa el edificio en formato legible.
     * @param string $value El atributo interno a devolver.
     * @return string
     */
    public function getAvAttribute($value)
    {
        $value = $this->removeDotInString($value);

        return $this->ucAndCleanString($value);
    }
}
