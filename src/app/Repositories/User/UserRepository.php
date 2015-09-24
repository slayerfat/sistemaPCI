<?php namespace PCI\Repositories\User;

use Illuminate\Pagination\LengthAwarePaginator;
use PCI\Mamarrachismo\PhoneParser\PhoneParser;
use PCI\Models\AbstractBaseModel;
use PCI\Repositories\AbstractRepository;
use PCI\Repositories\Interfaces\GetByNameOrIdInterface;
use PCI\Repositories\Interfaces\User\UserRepositoryInterface;
use PCI\Repositories\ViewVariable\ViewPaginatorVariable;

class UserRepository extends AbstractRepository implements UserRepositoryInterface, GetByNameOrIdInterface
{

    /**
     * @var \PCI\Models\User
     */
    protected $model;

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
     * Persiste informacion referente a una entidad.
     * Se sobrescribe del padre porque es
     * necesaria logica adicional.
     * @param array $data El array con informacion del modelo.
     * @return \PCI\Models\User
     */
    public function create(array $data)
    {
        /** @var \PCI\Models\User $user */
        $user = $this->newInstance();

        // detallese que se guarda la contraseña
        // de forma encriptada por medio de
        // la funcion global bcrypt.
        $user->name       = $data['name'];
        $user->email      = $data['email'];
        $user->password   = bcrypt($data['password']);
        $user->profile_id = $data['profile_id'];
        $user->confirmation_code = str_random(32);

        $user->save();

        return $user;
    }

    /**
     * Actualiza algun modelo y lo persiste
     * en la base de datos del sistema.
     * @param int $id El identificador unico.
     * @param array $data El arreglo con informacion relacioada al modelo.
     * @return \PCI\Models\User
     */
    public function update($id, array $data)
    {
        /** @var \PCI\Models\User $user */
        $user = $this->find($id);

        // si no se introdujo una nueva contraseña
        // entonces no se persiste la clave.
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
     * @param  string|int $id
     * @return \PCI\Models\AbstractBaseModel
     */
    public function find($id)
    {
        $user = $this->getByNameOrId($id);

        return $user;
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
        $results = $this->getTablePaginator();

        $variable = new ViewPaginatorVariable($results, 'users');

        return $variable;
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
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        $users = $this->model->all();

        return $users;
    }

    /**
     * genera la data necesaria que utilizara el paginator.
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
                'Nombres'  => $user->employee->formattedNames(),
                'C.I.'     => $user->employee->ci,
                'Telefono' => $phone
            ];

            return array_merge($partial, $employee);
        }

        $defaults = [
            'Nombres'  => '-',
            'C.I.'     => '-',
            'Telefono' => '-'
        ];

        return array_merge($partial, $defaults);
    }
}
