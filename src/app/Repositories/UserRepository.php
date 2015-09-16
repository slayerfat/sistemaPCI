<?php namespace PCI\Repositories;

use Input;
use PCI\Models\User;
use Illuminate\Database\Eloquent\Collection;
use PCI\Mamarrachismo\PhoneParser\PhoneParser;
use Illuminate\Pagination\LengthAwarePaginator;
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
     * Genera un objeto LengthAwarePaginator con todos los
     * usuarios en el sistema y con eager loading.
     * @param int $quantity
     * @return LengthAwarePaginator
     */
    public function getAllForTableWithPaginator($quantity = 25)
    {
        $users = $this->getAll();
        $users->load('profile', 'employee');

        return $this->generatePaginator($users, $quantity);
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

    /**
     * Genera un objeto LengthAwarePaginator con una coleccion paginada.
     * @link http://stackoverflow.com/a/29527744
     * @param Collection $results
     * @param int        $quantity
     * @return LengthAwarePaginator
     */
    protected function generatePaginator(Collection $results, $quantity)
    {
        $page = Input::get('page', 1);

        $items = $this->generatePaginatorContents($results);

        return new LengthAwarePaginator(
            $items->forPage($page, $quantity),
            $items->count(),
            $quantity,
            $page
        );
    }

    /**
     * Itera la coleccion y genera la informacion final
     * que se vera en la tabla de index.
     * @param Collection $results
     * @return \Illuminate\Support\Collection
     */
    protected function generatePaginatorContents(Collection $results)
    {
        $array = collect();

        $results->each(function ($user) use (&$array) {
            $names = $user->employee ? $user->employee->formattedNames() : '-';
            $id    = $user->employee ? $user->employee->ci : '-';
            $phone = '-';

            if ($user->employee) {
                $parser = new PhoneParser;

                $phone = $parser->parseNumber($user->employee->phone);
            }

            $array->push([
                'Seudonimo' => $user->name,
                'Email'     => $user->email,
                'Perfil'    => $user->profile->desc,
                'Nombres'   => $names,
                'C.I.'      => $id,
                'Telefono'  => $phone,
            ]);
        });

        return $array;
    }
}
