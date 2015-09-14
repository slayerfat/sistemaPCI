<?php namespace PCI\Repositories;

use PCI\Models\User;
use PCI\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{

    /**
     * @param  string|int $id
     * @return User
     */
    public function find($id)
    {
        $user = $this->getByNameOrId($id);

        return $user;
    }

    /**
     * @param array $data
     * @return User
     */
    public function getNewInstance(array $data)
    {
        return $this->newInstance($data);
    }

    /**
     * @return User
     */
    public function generateConfirmationCode()
    {
        $user = $this->getCurrentUser();

        $user->confirmation_code = str_random(32);

        $user->save();

        return $user;
    }
}
