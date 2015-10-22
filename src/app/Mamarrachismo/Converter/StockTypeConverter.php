<?php namespace PCI\Mamarrachismo\Converter;

use PCI\Mamarrachismo\Converter\interfaces\StockTypeConverterInterface;
use PCI\Models\Item;
use PCI\Models\StockType;

/**
 * Class StockTypeConverter
 *
 * @package PCI\Mamarrachismo\Converter
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class StockTypeConverter implements StockTypeConverterInterface
{

    /**
     * Id de gramos
     */
    const G = StockType::GRAM_ID;

    /**
     * Id de kilos
     */
    const K = StockType::KILO_ID;

    /**
     * Id de toneladas
     */
    const T = StockType::TON_ID;

    /**
     * El modelo de item a manipular.
     *
     * @var \PCI\Models\Item
     */
    private $item;

    /**
     * Los tipos de item que pueden ser convertidos.
     *
     * @var array
     */
    private $convertibleTypes = [
        self::G => [
            self::K => ['mul', 1000],
            self::T => ['mul', 1000000],
        ],
        self::K => [
            self::G => ['div', 1000],
            self::T => ['mul', 1000],
        ],
        self::T => [
            self::G => ['div', 1000000],
            self::K => ['div', 1000],
        ],
    ];

    /**
     * Genera una nueva instancia de este convertidor,
     * esta hecho para convertir las cantidades
     * del tipo de stock de un item.
     *
     * @param \PCI\Models\Item $item
     */
    public function __construct(Item $item = null)
    {
        $this->item = $item;
    }

    /**
     * Valida que la cantidad solicitada sea apropiada
     * al stock que posea determinado Item.
     *
     * @param int $type El tipo stock/cantidad
     * @return bool
     */
    public function validate($type)
    {
        $itemType = $this->item->stock_type_id;

        if ($type == $itemType) {
            return true;
        }

        return $this->isConvertible() && $this->isKeyValid($type, $this->convertibleTypes);
    }

    /**
     * Chequea si el tipo es convertible segun reglas.
     *
     * @return bool
     */
    public function isConvertible()
    {
        $type = $this->item->stock_type_id;

        return $this->isKeyValid($type, $this->convertibleTypes);
    }

    /**
     * @param int   $key
     * @param array $search
     * @return bool
     */
    private function isKeyValid($key, array $search)
    {
        return array_key_exists($key, $search);
    }

    /**
     * Convierte o trasforma la cantidad solicitada a
     * una cantidad compatible con el tipo de stock.
     *
     * @param int $type   El tipo stock/cantidad
     * @param int $amount la cantidad del pedido/nota/movimiento
     * @return int el numero transformado
     */
    public function convert($type, $amount)
    {
        // si el tipo es igual a si mismo no se necesita convertir nada.
        if ($type == $this->item->stock_type_id) {
            return $amount;
        }

        if (!$this->isValidSubType($type)) {
            return 0;
        }

        // nos interesa buscar en el arreglo cual es
        // el que esta relacionado con el item actual.
        $id    = $this->item->stock_type_id;
        $array = $this->convertibleTypes[$id];

        // como ya sabemos en que array estamos, tenemos que saber
        // cual de los tipos disponibles es el compatible con la operacion.
        $method  = $array[$type][0];
        $operand = $array[$type][1];

        return $this->$method($amount, $operand);
    }

    /**
     * @param int $type
     * @return bool
     */
    private function isValidSubType($type)
    {
        $key = $this->item->stock_type_id;

        foreach (array_keys($this->convertibleTypes[$key]) as $allowedKey) {
            if ($allowedKey == $type) {
                return true;
            }
        }

        return false;
    }

    /**
     * El modelo de item siendo manipulado.
     *
     * @return \PCI\Models\Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * El modelo del Item a manipular.
     *
     * @param  \PCI\Models\Item $item
     * @return \PCI\Models\Item
     */
    public function setItem(Item $item)
    {
        return $this->item = $item;
    }

    /**
     * Operacion basica de multiplicacion.
     *
     * @param $amount
     * @param $operand
     * @return int|float
     */
    protected function mul($amount, $operand)
    {
        return $amount * $operand;
    }

    /**
     * Operacion basica de division.
     *
     * @param $amount
     * @param $operand
     * @return int|float
     */
    protected function div($amount, $operand)
    {
        if ($operand == 0) {
            return 0;
        }

        return $amount / $operand;
    }
}
