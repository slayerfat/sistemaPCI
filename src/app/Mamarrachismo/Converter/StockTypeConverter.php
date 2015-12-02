<?php namespace PCI\Mamarrachismo\Convertidor;

use PCI\Mamarrachismo\Convertidor\interfaces\InterfaceStockTipoConvertidor;
use PCI\Modelos\Item;
use PCI\Modelos\StockTipo;

/**
 * Class StockTipoConvertidor
 *
 * @package PCI\Mamarrachismo\Convertidor
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class StockTipoConvertidor implements InterfaceStockTipoConvertidor
{

    /**
     * Id de gramos
     */
    const G = StockTipo::GRAMO_ID;

    /**
     * Id de kilos
     */
    const K = StockTipo::KILO_ID;

    /**
     * Id de toneladas
     */
    const T = StockTipo::TON_ID;

    /**
     * El modelo de item a manipular.
     *
     * @var \PCI\Modelos\Item
     */
    private $item;

    /**
     * Los tipos de item que pueden ser convertidos.
     *
     * @var array
     */
    private $convertibletipos = [
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
     * @param \PCI\Modelos\Item $item
     */
    public function __construct(Item $item = null)
    {
        $this->item = $item;
    }

    /**
     * Valida que la cantidad solicitada sea apropiada
     * al stock que posea determinado Item.
     *
     * @param int $tipo El tipo stock/cantidad
     * @return bool
     */
    public function validar($tipo)
    {
        $itemtipo = $this->item->stock_tipo_id;

        if ($tipo == $itemtipo) {
            return true;
        }

        return $this->esConvertible() && $this->esKeyValida($tipo, $this->convertibletipos);
    }

    /**
     * Chequea si el tipo es convertible segun reglas.
     *
     * @return bool
     */
    public function esConvertible()
    {
        $tipo = $this->item->stock_tipo_id;

        return $this->esKeyValida($tipo, $this->convertibletipos);
    }

    /**
     * Determina si algun key existe en el array a buscar.
     *
     * @param int   $key
     * @param array $search
     *
     * @return bool
     */
    private function esKeyValida($key, array $search)
    {
        return array_key_exists($key, $search);
    }

    /**
     * Convierte o trasforma la cantidad solicitada a
     * una cantidad compatible con el tipo de stock.
     *
     * @param int $tipo     El tipo stock/cantidad
     * @param int $cantidad la cantidad del pedido/nota/movimiento
     * @return int el numero transformado
     */
    public function convertir($tipo, $cantidad)
    {
        // si el tipo es igual a si mismo no se necesita convertir nada.
        if ($tipo == $this->item->stock_tipo_id) {
            return $cantidad;
        }
        
        $esSubtipoValido = $this->esSubtipoValidoValido($tipo);

        if (!($this->esConvertible() && $esSubtipoValido)) {
            return 0;
        }

        // nos interesa buscar en el arreglo cual es
        // el que esta relacionado con el item actual.
        $id    = $this->item->stock_tipo_id;
        $array = $this->convertibletipos[$id];

        // como ya sabemos en que array estamos, tenemos que saber
        // cual de los tipos disponibles es el compatible con la operacion.
        $metodo   = $array[$tipo][0];
        $operador = $array[$tipo][1];

        return call_user_func([$this, $metodo], $operador);
    }

    /**
     * @param int $tipo
     * @return bool
     */
    private function subtipoValido($tipo)
    {
        $key = $this->item->stock_tipo_id;

        foreach (array_keys($this->convertibletipos[$key]) as $tipoValido) {
            if ($tipoValido == $tipo) {
                return true;
            }
        }

        return false;
    }

    /**
     * El modelo de item siendo manipulado.
     *
     * @return \PCI\Modelos\Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * El modelo del Item a manipular.
     *
     * @param  \PCI\Modelos\Item $item
     * @return \PCI\Modelos\Item
     */
    public function setItem(Item $item)
    {
        return $this->item = $item;
    }

    /**
     * Operacion basica de multiplicacion.
     *
     * @param $cantidad
     * @param $operador
     * @return int|float
     */
    protected function mul($cantidad, $operador)
    {
        return $cantidad * $operador;
    }

    /**
     * Operacion basica de division.
     *
     * @param $cantidad
     * @param $operador
     * @return int|float
     */
    protected function div($cantidad, $operador)
    {
        if ($operador == 0) {
            return 0;
        }

        return $cantidad / $operador;
    }
}
