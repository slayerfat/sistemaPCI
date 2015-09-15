<?php namespace PCI\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use PCI\Models\User;

interface UserRepositoryInterface
{

    /**
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
     * @return User
     */
    public function generateConfirmationCode();

    /**
     * @param string $code
     * @return bool
     */
    public function confirm($code);

    /**
     * @return Collection
     */
    public function getAll();
}
