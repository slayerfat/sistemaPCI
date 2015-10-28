<?php namespace PCI\Listeners\Note;

use Date;
use PCI\Mamarrachismo\Converter\interfaces\StockTypeConverterInterface;
use PCI\Models\Item;
use PCI\Models\Movement;
use PCI\Models\Note;

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
     * Esta clase necesita el convertidor para generar las cantidades.
     *
     * @param StockTypeConverterInterface $converter
     */
    public function __construct(StockTypeConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    /**
     * Ajusta en la base de datos el stock de los items en los almacenes.
     *
     * @param \PCI\Models\Item $item
     * @param  array           $depotsWithStock
     * @return void
     */
    protected function reattachDepots(Item $item, array $depotsWithStock)
    {
        $item->depots()->sync([]);

        $this->attachDepots($item, $depotsWithStock);
    }

    /**
     * Ajusta en la base de datos el stock de los items en los almacenes.
     *
     * @param \PCI\Models\Item $item
     * @param  array           $depotsWithStock
     * @return void
     */
    protected function attachDepots(Item $item, array $depotsWithStock)
    {
        foreach ($depotsWithStock as $id => $details) {
            $item->depots()->attach($id, $details);
        }
    }

    /**
     * Crea los movimientos relacionados con Los items en la nota.
     *
     * @param \PCI\Models\Note $note
     * @param array            $data [ID][cantidad,tipo]
     * @return bool
     */
    protected function setMovement(Note $note, array $data)
    {
        if (count($data) == 0) {
            return false;
        }

        // TODO: repo
        $movement = new Movement;

        $movement->movement_type_id = $note->type->movement_type_id;
        $movement->creation         = Date::now();
        $note->movements()->save($movement);

        foreach ($data as $id => $array) {
            $movement->items()->attach($id, $array);
        }

        return true;
    }
}
