<?php namespace PCI\Repositories\Interfaces;

interface ModelRepositoryInterface
{

    /**
     * Busca algun Elemento segun Id u otra regla.
     * @param  string|int $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find($id);

    /**
     * Busca algun elemento segun su ID.
     * @param  mixed $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getById($id);

    /**
     * Consigue todos los elementos y devuelve una coleccion.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll();

    /**
     * Genera una nueva instancia Eloquent.
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function newInstance(array $data = []);

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data);

    /**
     * Actualiza algun moodelo.
     * @param int   $id
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($id, array $data);

    /**
     * Elimina del sistema un modelo.
     * @param $id
     * @return bool|\Illuminate\Database\Eloquent\Model
     */
    public function delete($id);
}
