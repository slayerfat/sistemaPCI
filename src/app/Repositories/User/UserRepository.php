<?php namespace PCI\Repositories\User;

use Html;
use Illuminate\Pagination\LengthAwarePaginator;
use PCI\Mamarrachismo\PhoneParser\PhoneParser;
use PCI\Models\AbstractBaseModel;
use PCI\Models\User;
use PCI\Repositories\AbstractRepository;
use PCI\Repositories\Interfaces\GetByNameOrIdInterface;
use PCI\Repositories\Interfaces\User\UserRepositoryInterface;
use PCI\Repositories\ViewVariable\ViewPaginatorVariable;

/**
 * Class UserRepository
 *
 * @package PCI\Repositories\User
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class UserRepository extends AbstractRepository implements UserRepositoryInterface, GetByNameOrIdInterface
{

    /**
     * El repositorio del que depende este.
     *
     * @var \PCI\Models\User
     */
    protected $model;

    /**
     * genera un codigo de 32 caracteres para validar
     * al usuario por correo por primera vez.
     *
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
     * confirma el codigo previamente creado.
     *
     * @param string $code El codigo de 32 caracteres.
     * @return bool Verdaredo si existe un usuario con este codigo.
     */
    public function confirmCode($code)
    {
        $user = $this->model->whereConfirmationCode($code)->first();

        // si no hay usuario este no sera confirmado.
        if (is_null($user)) {
            return false;
        }

        // si existe el codigo se cambia a nulo que significa que el
        // usuario no posee condigo de confirmacion
        // por ende esta confirmado.
        $user->confirmation_code = null;
        $user->save();

        return true;
    }

    /**
     * Persiste informacion referente a una entidad.
     * Se sobrescribe del padre porque es
     * necesaria logica adicional.
     *
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
        $user->name              = $data['name'];
        $user->email             = $data['email'];
        $user->password          = bcrypt($data['password']);
        $user->profile_id        = $data['profile_id'];
        $user->confirmation_code = str_random(32);

        $user->save();

        return $user;
    }

    /**
     * Actualiza algun modelo y lo persiste
     * en la base de datos del sistema.
     *
     * @param int   $id   El identificador unico.
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
     * Busca algun Elemento segun Id u otra regla.
     *
     * @param  string|int $id El identificador unico (slug|name|etc|id).
     * @return \PCI\Models\AbstractBaseModel
     */
    public function find($id)
    {
        $user = $this->getByNameOrId($id);

        return $user;
    }

    /**
     * Busca en la base de datos algun modelo
     * que tenga un campo nombre y/o id.
     *
     * @param  string|int $id El identificador (name|id)
     * @return \PCI\Models\User
     */
    public function getByNameOrId($id)
    {
        return $this->getByIdOrAnother($id, 'name');
    }

    /**
     * Elimina del sistema un modelo.
     *
     * @param int $id El identificador unico.
     * @return boolean|\PCI\Models\AbstractBaseModel
     */
    public function delete($id)
    {
        return $this->executeDelete($id, 'Usuario');
    }

    /**
     * Regresa variable con una coleccion y datos
     * adicionales necesarios para generar la vista.
     *
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
     *
     * @param int $quantity la cantidad a mostrar por pagina.
     * @return LengthAwarePaginator
     */
    public function getTablePaginator($quantity = 25)
    {
        $users = $this->getAll()->load('profile', 'employee')->sortBy('name');

        return $this->generatePaginator($users, $quantity);
    }

    /**
     * Consigue todos los elementos y devuelve una coleccion.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        $users = $this->model->all();

        return $users;
    }

    /**
     * Regresa una arreglo de los usuarios que
     * sean administradores del sistema.
     *
     * @return \Illuminate\Support\Collection
     */
    public function adminLists()
    {
        return $this->model
            ->whereProfileId(\PCI\Models\User::ADMIN_ID)
            ->get();
    }

    /**
     * Regresa una coleccion de los usuarios activos en el sistema.
     *
     * @return \Illuminate\Support\Collection
     */
    public function usersList()
    {
        return $this->model
            ->where('profile_id', User::USER_ID)
            ->orWhere('profile_id', User::ADMIN_ID)
            ->get();
    }

    /**
     * genera la data necesaria que utilizara el paginator.
     *
     * @param \PCI\Models\AbstractBaseModel|\PCI\Models\User $user
     * @return array
     */
    protected function makePaginatorData(AbstractBaseModel $user)
    {
        // estos son los datos propios
        // del usuario que nos interesa.
        $partial = [
            'uid'       => $user->name,
            'Seudónimo' => link_to_route('profiles.show', $user->name, $user->name),
            'Email'     => Html::mailto($user->email),
            'Perfil'    => link_to_route('profiles.show', $user->profile->desc, $user->profile->slug),
        ];

        // si el usuario tiene informacion de empleado
        // entonces nos conviene extraer esta.
        if ($user->employee) {
            $parser = new PhoneParser;

            $phone = $parser->parseNumber($user->employee->phone);

            $employee = [
                'Nombres'  => $user->employee->formattedNames(),
                'C.I.'     => $user->employee->ci,
                'Teléfono' => $phone,
            ];

            // una vez complado unimos los dos arreglos en uno solo
            return array_merge($partial, $employee);
        }

        // como el usuario no posee informacion de personal
        // creamos este arreglo con datos por defecto
        // para que se vea bonito en la vista.
        $defaults = [
            'Nombres'  => '-',
            'C.I.'     => '-',
            'Teléfono' => '-',
        ];

        return array_merge($partial, $defaults);
    }
}
