<?php namespace PCI\Repositories\Interfaces;

interface ModelRepositoryInterface
{

    /**
     * Busca algun Elemento segun Id u otra regla.
     * @param  string|int $id
     * @return \PCI\Repositories\AbstractRepository
     */
    public function find($id);

    /**
     * Busca algun elemento segun su ID.
     * @param  mixed $id
     * @return \PCI\Repositories\AbstractRepository
     */
    public function getById($id);

    /**
     * Consigue todos los elementos y devuelve una coleccion.
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getAll();

    /**
     * Genera una nueva instancia Eloquent.
     * @param array $data
     * @return \PCI\Repositories\AbstractRepository
     */
    public function newInstance(array $data = []);

    /**
     * @param array $data
     * @return \PCI\Repositories\AbstractRepository
     */
    public function create(array $data);

    /**
     * Actualiza algun modelo.
     * @param int   $id
     * @param array $data
     * @return \PCI\Repositories\AbstractRepository
     */
    public function update($id, array $data);

    /**
     * Elimina del sistema un modelo.
     * @param $id
     * @return boolean|\PCI\Repositories\AbstractRepository
     */
    public function delete($id);
}
