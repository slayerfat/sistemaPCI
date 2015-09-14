<?php namespace PCI\Repositories\Interfaces;

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
    public function getNewInstance(array $data);

    /**
     * @return User
     */
    public function generateConfirmationCode();

    /**
     * @param string $code
     * @return bool
     */
    public function confirm($code);
}
