<?php namespace PCI\Mamarrachismo\Converter;

use PCI\Mamarrachismo\Converter\interfaces\StockTypeConverterInterface;
use PCI\Models\Item;

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
     * El modelo de item a manipular.
     *
     * @var \PCI\Models\Item
     */
    private $item;

    /**
     * Los tipos de item que pueden ser convertidos.
     * FIXME?
     *
     * @var array
     */
    private $convertibleTypes = [
        2 => [3 => ['div', 1000], 4 => ['div', (1000 * 1000)]],
        3 => [2 => ['mul', 1000], 4 => ['div', 1000]],
        4 => [2 => ['mul', (1000 * 1000)], 3 => ['div', 1000]],
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
        if ($type == $this->item->stock_type_id) {
            return true;
        }

        return $this->isConvertible();
    }

    /**
     * Chequea si el tipo es convertible segun reglas.
     *
     * @return bool
     */
    public function isConvertible()
    {
        return array_key_exists($this->item->stock_type_id, $this->convertibleTypes);
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

        // nos interesa buscar en el arreglo cual es
        // el que esta relacionado con el item actual.
        $id    = $this->item->stock_type_id;
        $array = $this->convertibleTypes[$id];

        // como ya sabemos en que array estamos, tenemos que saber
        // cual de los tipos disponibles es el compatible con la operacion.
        $array   = $array[$type];
        $method  = $array[0];
        $operand = $array[1];

        return $this->$method($amount, $operand);
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
}
