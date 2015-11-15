<?php namespace PCI\Events\Note;

use Illuminate\Support\Collection;
use PCI\Mamarrachismo\Collection\ItemCollection;
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
     * @var ItemCollection [item_id, depot_id, due]
     */
    public $data;

    /**
     * Esta clase necesita que el array asociativo
     * este construido correctamente o generara un error.
     *
     * @param \PCI\Models\Note $note
     * @param ItemCollection   $data [item_id, nota_id]
     */
    public function __construct(Note $note, ItemCollection $data)
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
     * @param ItemCollection $data
     */
    public function setData(ItemCollection $data)
    {
        $this->data = $data->unique();
    }
}
