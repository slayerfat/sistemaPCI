<?php namespace PCI\Repositories;

use PCI\Models\AbstractBaseModel;
use PCI\Mamarrachismo\PhoneParser\PhoneParser;
use Illuminate\Pagination\LengthAwarePaginator;
use PCI\Repositories\ViewVariable\ViewPaginatorVariable;
use PCI\Repositories\Interfaces\User\UserRepositoryInterface;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{

    /**
     * @var \PCI\Models\User
     */
    protected $model;

    /**
     * @param  string|int $id
     * @return \PCI\Models\AbstractBaseModel
     */
    public function find($id)
    {
        $user = $this->getByNameOrId($id);

        return $user;
    }

    /**
     * @return \PCI\Models\User
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
     * @return boolean
     */
    public function confirmCode($code)
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
     * @return \Illuminate\Database\Eloquent\Collection
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
    public function getTablePaginator($quantity = 25)
    {
        $users = $this->getAll();
        $users->load('profile', 'employee');

        return $this->generatePaginator($users, $quantity);
    }

    /**
     * @param array $data
     * @return \PCI\Repositories\AbstractRepository|null
     */
    public function create(array $data)
    {
        /** @var \PCI\Models\User $user */
        $user = $this->newInstance();

        $user->name       = $data['name'];
        $user->email      = $data['email'];
        $user->password   = bcrypt($data['password']);
        $user->profile_id = $data['profile_id'];
        $user->confirmation_code = str_random(32);

        $user->save();

        return $user;
    }

    /**
     * Actualiza algun modelo.
     * @param int   $id
     * @param array $data
     * @return \PCI\Models\AbstractBaseModel
     */
    public function update($id, array $data)
    {
        /** @var \PCI\Models\User $user */
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
     * genera la data necesaria que utilizara el paginator.
     *
     * @param \PCI\Models\AbstractBaseModel|\PCI\Models\User $user
     * @return array
     */
    protected function makePaginatorData(AbstractBaseModel $user)
    {
        $partial = [
            'uid'       => $user->name,
            'Seudonimo' => $user->name,
            'Email'     => $user->email,
            'Perfil'    => $user->profile->desc
        ];

        if ($user->employee) {
            $parser = new PhoneParser;

            $phone = $parser->parseNumber($user->employee->phone);

            $employee = [
                'Nombres'   => $user->employee->formattedNames(),
                'C.I.'      => $user->employee->ci,
                'Telefono'  => $phone
            ];

            return array_merge($partial, $employee);
        }

        $defaults = [
            'Nombres'   => '-',
            'C.I.'      => '-',
            'Telefono'  => '-'
        ];

        return array_merge($partial, $defaults);
    }

    /**
     * Elimina del sistema un modelo.
     * @param $id
     * @return boolean|\PCI\Models\AbstractBaseModel
     */
    public function delete($id)
    {
        return $this->executeDelete($id, 'Usuario');
    }

    /**
     * Regresa variable con una coleccion y datos
     * adicionales necesarios para generar la vista.
     * @return \PCI\Repositories\ViewVariable\ViewPaginatorVariable
     */
    public function getIndexViewVariables()
    {
        $results  = $this->getTablePaginator();

        $variable = new ViewPaginatorVariable($results, 'users');

        return $variable;
    }
}
