<?php namespace PCI\Repositories\Aux;

use PCI\Repositories\AbstractRepository;
use PCI\Repositories\Interfaces\CategoryRepositoryInterface;
use PCI\Repositories\Interfaces\ViewableInterface;
use PCI\Repositories\ViewVariables;

class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface, ViewableInterface
{

    /**
     * Busca algun Elemento segun Id u otra regla.
     * @param  string|int $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find($id)
    {
        // TODO: Implement find() method.
    }

    /**
     * Consigue todos los elementos y devuelve una coleccion.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    /**
     * Actualiza algun moodelo.
     * @param int   $id
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($id, array $data)
    {
        // TODO: Implement update() method.
    }

    /**
     * Elimina del sistema un modelo.
     * @param $id
     * @return bool|\Illuminate\Database\Eloquent\Model
     */
    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * regresa la informacion necesaria para generar la vista.
     * esta necesita el destino y el nombre de
     * la variable para el Model Binding.
     * @return \PCI\Repositories\ViewVariables
     */
    public function getViewVariables()
    {
        return new ViewVariables(
            $this->newInstance(),
            'cat'
        );
    }
}
