<?php namespace PCI\Events\Note;

use Illuminate\Support\Collection;
use LogicException;
use PCI\Models\Note;

/**
 * Class NewItemIngress
 *
 * @package PCI\Events\Note
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class NewItemIngress extends NewNoteCreation
{

    /**
     * La informacion necesaria para completar el nuevo ingreso al almacen.
     * continene una coleccion con arrays asociativos.
     *
     * @var Collection [item_id, depot_id, due]
     */
    public $data;

    /**
     * Esta clase necesita que el array asociativo
     * este construido correctamente o generara un error.
     *
     * @param \PCI\Models\Note $note
     * @param Collection       $data [item_id, nota_id]
     */
    public function __construct(Note $note, Collection $data)
    {
        parent::__construct($note);

        $this->setData($data);
    }

    /**
     * @return Collection
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param Collection $data
     */
    public function setData(Collection $data)
    {
        $this->checkData($data);
        $collection = collect();
        $group      = $data->groupBy('item_id');

        /** @var Collection $single */
        foreach ($group as $id => $single) {
            $collection->offsetSet($id, $single->unique());
        }

        $this->data = $collection;
    }

    /**
     * @param Collection $data [item_id, depot_id]
     * @return void
     */
    private function checkData(Collection $data)
    {
        if ($data->isEmpty()) {
            throw new LogicException('El arreglo de datos, debe contener el id del item y elementos asociados.');
        }

        foreach ($data as $array) {
            if (!array_key_exists('depot_id', $array) || !array_key_exists('due', $array)) {
                throw new LogicException('El arreglo de datos, esta construido incorrectamente.');
            }
        }
    }
}
