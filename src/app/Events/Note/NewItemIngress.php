<?php namespace PCI\Events\Note;

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
     *
     * @var array este array es asociativo [item, nota]
     */
    public $data;

    /**
     * Esta clase necesita que el array asociativo
     * este construido correctamente o generara un error.
     *
     * @param \PCI\Models\Note $note
     * @param array            $data este array es asociativo [item, nota]
     */
    public function __construct(Note $note, array $data)
    {
        parent::__construct($note);

        $this->checkDataArray($data);

        $this->data = $data;
    }

    /**
     * @param array $data
     * @return void
     */
    private function checkDataArray(array $data)
    {
        if (count($data) == 0) {
            throw new LogicException('El arreglo de datos, esta construido incorrectamente.');
        }

        foreach ($data as $array) {
            if (!isset($array['depot_id'])) {
                throw new LogicException('El arreglo de datos, esta construido incorrectamente.');
            }
        }
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->checkDataArray($data);

        $this->data = $data;
    }
}
