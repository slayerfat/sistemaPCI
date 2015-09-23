<?php namespace PCI\Http\Requests\User;

use Gate;
use PCI\Http\Requests\Request;
use PCI\Repositories\Interfaces\User\UserRepositoryInterface;

class UserRequest extends Request
{

    /**
     * @var \PCI\Repositories\Interfaces\User\UserRepositoryInterface
     */
    private $userRepo;

    /**
     * Genera la instancia del user request dandole el repositorio de usuarios.
     * @param \PCI\Repositories\Interfaces\User\UserRepositoryInterface $userRepo
     */
    public function __construct(UserRepositoryInterface $userRepo)
    {
        parent::__construct();

        $this->userRepo = $userRepo;
    }

    /**
     * Determina si el usuario esta autorizado a hacer esta peticion.
     * @return bool
     */
    public function authorize()
    {
        if ($this->creating()) {
            return true;
        }

        $user = $this->userRepo->find($this->route('users'));

        return Gate::allows('update', $user);
    }

    /**
     * Obtiene las reglas de validacion que seran aplicadas a esta peticion.
     * @return array<string, string>
     */
    public function rules()
    {
        // Se necesita saber si el usuario esta o no actualizando algun recurso
        // es por eso que se chequea si el metodo del formulario es patch
        // o put (actualizacion), de ser asi se necesita cambiar un
        // poco las reglas para permitir que los campos unicos
        // se repitan solo para ese usuario, es decir
        // name => required: excepto si mismo.
        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                return [
                    'name'  => 'required|max:20|alpha-dash|unique:users,name,' . (int) $this->route('users'),
                    'email' => 'required|email|max:255|unique:users,email,' . (int) $this->route('users'),
                    'password'   => 'confirmed|min:6',
                    'profile_id' => 'required|numeric',
                ];

            default:
                return [
                    'name'       => 'required|max:20|alpha-dash|unique:users',
                    'email'      => 'required|email|max:255|unique:users',
                    'password'   => 'required|confirmed|min:6',
                    'profile_id' => 'required|numeric',
                ];
        }
    }
}
