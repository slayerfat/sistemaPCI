<?php namespace PCI\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use PCI\Models\User;

interface UserRepositoryInterface
{

    /**
     * Busca al usuario por nombre o id
     *
     * @param  string|int $id
     *
     * @return User
     */
    public function find($id);

    /**
     * @param array $data
     * @return User
     */
    public function getNewInstance(array $data = []);

    /**
     * genera un codigo de 32 caracteres para validar
     * al usuario por correo por primera vez.
     * @return User
     */
    public function generateConfirmationCode();

    /**
     * confirma el codigo previamente creado.
     *
     * @param string $code
     * @return bool
     */
    public function confirm($code);

    /**
     * @return Collection
     */
    public function getAll();

    /**
     * @param int $quantity
     * @return LengthAwarePaginator
     */
    public function getAllForTableWithPaginator($quantity = 25);

    /**
     * @param array $data
     * @return User
     */
    public function create(array $data);

    /**
     * actualiza al usuario y se le asigna el perfil de una vez,
     * adicionalmente se chequea si hay o no contraseña
     * y se actualiza adecuandamente.
     * @param int   $id
     * @param array $data
     * @return User
     */
    public function update($id, array $data);

    /**
     * @param $id
     * @return bool|User
     */
    public function delete($id);
}
