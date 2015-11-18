<?php namespace PCI\Listeners\Note;

use Illuminate\Support\Collection;
use PCI\Mamarrachismo\Converter\interfaces\StockTypeConverterInterface;
use PCI\Models\Movement;

/**
 * Class AbstractItemMovement
 *
 * @package PCI\Listeners\Note
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
abstract class AbstractItemMovement
{

    /**
     * La implementacion del convertidor para las cantidades.
     *
     * @var \PCI\Mamarrachismo\Converter\StockTypeConverter
     */
    protected $converter;

    /**
     * @var \PCI\Models\Movement
     */
    protected $movement;

    /**
     * @var Collection|\PCI\Models\ItemMovement[]
     */
    protected $itemMovements;

    /**
     * Esta clase necesita el convertidor para generar las cantidades.
     *
     * @param StockTypeConverterInterface           $converter
     * @param \PCI\Models\Movement                  $movement
     * @param Collection|\PCI\Models\ItemMovement[] $itemMovements
     */
    public function __construct(
        StockTypeConverterInterface $converter,
        Movement $movement,
        Collection $itemMovements
    ) {
        $this->converter     = $converter;
        $this->movement      = $movement;
        $this->itemMovements = $itemMovements;
    }
}
