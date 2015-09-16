<?php namespace PCI\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use PCI\Models\User;
use Illuminate\Database\Eloquent\Collection;
use PCI\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{

    /**
     * @var User
     */
    protected $model;

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
    public function getNewInstance(array $data = [])
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

    /**
     * @param string $code
     * @return bool
     */
    public function confirm($code)
    {
        $user = $this->model->whereConfirmationCode($code)->first();

        if (is_null($user)) {
            return false;
        }

        $user->confirmation_code = null;
        $user->save();

        return true;
    }

    /**
     * @return Collection
     */
    public function getAll()
    {
        $users = $this->model->all();

        return $users;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAllForTableWithPaginator()
    {
        $results = $this->getAll();

        $array = [];

        $results->each(function ($user) use (&$array) {
            $names   = $user->employee ? $user->employee->formattedNames() : '-';

            $array[] = [
                'Nombre'  => $user->name,
                'Email'   => $user->email,
                'Perfil'  => $user->profile->desc,
                'Nombres' => $names,
            ];
        });

        return $array;
    }

    /**
     * @param array $data
     * @return User
     */
    public function create(array $data)
    {
        $user = $this->getNewInstance();

        $user->name       = $data['name'];
        $user->email      = $data['email'];
        $user->password   = bcrypt($data['password']);
        $user->profile_id = $data['profile_id'];
        $user->confirmation_code = str_random(32);

        $user->save();

        return $user;
    }

    /**
     * @param int   $id
     * @param array $data
     * @return User
     */
    public function update($id, array $data)
    {
        $user = $this->find($id);

        if (trim($data['password']) != '') {
            $user->password = bcrypt($data['password']);
        }

        $user->name       = $data['name'];
        $user->email      = $data['email'];
        $user->profile_id = $data['profile_id'];

        $user->save();

        return $user;
    }
}
