<?php namespace PCI\Mamarrachismo\Collection;

use ArrayAccess;
use ArrayIterator;
use Carbon\Carbon;
use Countable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use InvalidArgumentException;
use IteratorAggregate;
use LogicException;
use Traversable;

/**
 * Class ItemCollection
 *
 * @package PCI\Mamarrachismo\ItemCollection
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 * @link    https://ragarwo.files.wordpress.com/2014/02/12968-i-have-no-idea-what-im-doing1.jpg
 */
class ItemCollection implements Countable, ArrayAccess, IteratorAggregate
{

    /**
     * los keys del arreglo que deben ser inspeccionados.
     * en snake_case_only_plz
     *
     * @var array
     */
    private $defaults = ['item_id', 'depot_id', 'due', 'amount'];

    /**
     * @var \Illuminate\Support\Collection
     */
    private $collection;

    /**
     * los keys del arreglo que deben ser inspeccionados.
     *
     * @var array
     */
    private $customRules = [];

    /**
     * Determina si la coleccion fue inspeccionada.
     *
     * @var bool
     */
    private $checked = false;

    /**
     * @var int|string
     */
    private $itemId;

    /**
     * @var int|string
     */
    private $depotId;

    /**
     * @var number
     */
    private $amount;

    /**
     * @var int|null|string
     */
    private $stockTypeId;

    /**
     * @var null|string
     */
    private $due;

    /**
     * Para este asunto, solo necesitamos la coleccion.
     */
    public function __construct()
    {
        $this->collection = new Collection;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $this->checkCollection();

        return $this->collection->toJson();
    }

    /**
     * Chequea que la coleccion existente este correcta.
     *
     * @return void
     */
    private function checkCollection()
    {
        if ($this->checked) {
            return;
        }

        if ($this->collection->isEmpty()) {
            throw new LogicException('El arreglo de datos, debe contener el id del item y elementos asociados.');
        }

        $rules = $this->getRules();

        foreach ($this->collection as $array) {
            foreach ($rules as $key) {
                if (!array_key_exists($key, $array)) {
                    throw new InvalidArgumentException("El arreglo de datos, no posee [$key] y es requerido.");
                }
            }
        }

        $this->checked = true;
    }

    /**
     * Determina las reglas a usar por esta clase.
     *
     * @return array
     */
    private function getRules()
    {
        return count($this->customRules) >= 1
            ? $this->customRules
            : $this->defaults;
    }

    /**
     * @return int|string
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @param int|string $itemId
     * @return $this
     */
    public function setItemId($itemId)
    {
        $data = $this->getSetData('itemId', $itemId);

        $this->itemId = $data;

        return $this;
    }

    /**
     * @param $name
     * @param $value
     * @return number
     */
    private function getSetData($name, $value)
    {
        $this->checked = false;

        if (is_array($value)) {
            $key = Str::snake($name);

            return isset($value[$key]) ? $value[$key] : null;
        } elseif (is_numeric($value)) {
            return $value <= 0 ? null : $value;
        }

        return null;
    }

    /**
     * @return int|string
     */
    public function getDepotId()
    {
        return $this->depotId;
    }

    /**
     * @param int|string $depotId
     * @return $this
     */
    public function setDepotId($depotId)
    {
        $data = $this->getSetData('depotId', $depotId);

        $this->depotId = $data;

        return $this;
    }

    /**
     * @return number
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param number $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $data = $this->getSetData('amount', $amount);

        $this->amount = $data;

        return $this;
    }

    /**
     * @return int|null|string
     */
    public function getStockTypeId()
    {
        return $this->stockTypeId;
    }

    /**
     * @param int|null|string $stockTypeId
     * @return $this
     */
    public function setStockTypeId($stockTypeId)
    {
        $data = $this->getSetData('stockTypeId', $stockTypeId);

        $this->stockTypeId = $data;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDue()
    {
        return $this->due;
    }

    /**
     * @param null|string $due
     * @return $this
     */
    public function setDue($due)
    {
        if (is_array($due)
            || is_null($due)
            || is_numeric($due)
            || preg_match('/[0-9]{4}/', $due) !== 1
        ) {
            $this->due     = null;
            $this->checked = false;

            return $this;
        }

        try {
            $this->due = Carbon::parse($due)->toDateTimeString();
        } catch (\Exception $e) {
            $this->due = null;
        }

        $this->checked = false;

        return $this;
    }

    /**
     * Cambia los campos por defecto que deben existir
     * dentro del arreglo para entrar en la coleccion.
     *
     * @param array|mixed ...$rules
     * @return $this
     */
    public function setRequiredFields($rules)
    {
        $array   = is_array($rules) ? $rules : func_get_args();
        $results = [];
        foreach ($array as $key) {
            $results[] = Str::snake($key);
        }

        $this->customRules = $results;
        $this->checked     = false;

        return $this;
    }

    /**
     * Count elements of an object
     *
     * @link  http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return $this->collection->count();
    }

    /**
     * Whether a offset exists
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset
     * @return boolean true on success or false on failure.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return $this->collection->offsetExists($offset);
    }

    /**
     * Offset to retrieve
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->collection->offsetGet($offset);
    }

    /**
     * Offset to unset
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        $this->collection->offsetUnset($offset);
    }

    /**
     * Retrieve an external iterator
     *
     * @link  http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getCollection()->toArray());
    }

    /**
     * @return Collection
     */
    public function getCollection()
    {
        $this->checkCollection();

        return $this->collection->groupBy('item_id');
    }

    /**
     * Mete el array generado de los atributos de esta clase a la coleccion.
     *
     * @return $this
     */
    public function make()
    {
        $array = [];

        $rules = $this->getRules();

        foreach ($rules as $key) {
            $attr = Str::camel($key);
            if (isset($this->$attr)) {
                $array[$key] = $this->$attr;
            }
        }

        $this->push($array);

        return $this;
    }

    /**
     * Basicamente duplica Collection, pero nos interesa
     * resetear el flag, para que se chequee la coleccion.
     *
     * @param $items
     * @return $this
     */
    public function push(array $items)
    {
        if (count($items) < 1) {
            return $this;
        }

        $this->collection->push($items);
        $this->checked = false;

        return $this;
    }

    /**
     * Regresa a status quo
     *
     * @return $this
     */
    public function reset()
    {
        $this->collection  = new Collection;
        $this->customRules = [];

        return $this;
    }

    /**
     * Busca en la coleccion y elimina los elementos duplicados,
     * es decir, solo mantiene los elementos unicos.
     *
     * @return \Illuminate\Support\Collection
     */
    public function unique()
    {
        $collection = $this->getCollection();
        foreach ($collection as $id => $single) {
            $collection->offsetSet($id, $single->unique());
        }

        return $collection;
    }

    /**
     * Offset to set
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset
     * @param mixed $value
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->collection->offsetSet($offset, $value);
    }
}
