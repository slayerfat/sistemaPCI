<?php namespace PCI\Mamarrachismo\Converter\interfaces;

interface StockTypeConverterInterface
{

    /**
     * Valida que la cantidad solicitada sea apropiada
     * al stock que posea determinado Item.
     *
     * @param int $type El tipo de stock/cantidad
     * @return bool
     */
    public function validate($type);

    /**
     * Convierte o trasforma la cantidad solicitada a
     * una cantidad compatible con el tipo de stock.
     *
     * @param int $type   El tipo stock/cantidad
     * @param int $amount la cantidad del pedido/nota/movimiento
     * @return int el numero transformado
     */
    public function convert($type, $amount);

    /**
     * Chequea si el tipo es convertible segun reglas.
     *
     * @return bool
     */
    public function isConvertible();
}
