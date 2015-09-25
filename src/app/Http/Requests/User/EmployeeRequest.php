<?php namespace PCI\Http\Requests\User;

use PCI\Http\Requests\Request;
use PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class EmployeeRequest
 * @package PCI\Http\Requests\User
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class EmployeeRequest extends Request
{

    /**
     * @var \PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface
     */
    private $empRepo;

    /**
     * Genera la instancia del user request dandole el repositorio de usuarios.
     * @param \PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface $empRepo
     */
    public function __construct(EmployeeRepositoryInterface $empRepo)
    {
        parent::__construct();

        $this->empRepo = $empRepo;
    }

    /**
     * Determina si el usuario esta autorizado a hacer esta peticion.
     * @return bool
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function authorize()
    {
        // necesitamos saber que tipo de request es
        switch ($this->method()) {
            // este caso esta actualizando
            case 'PUT':
            case 'PATCH':
                $employee = $this->empRepo->find($this->route('employees'));

                return $this->user()->can('update', $employee);

            // este caso esta creando
            case 'POST':
                $user = $this->empRepo->findParent($this->route('users'));

                return $this->user()->can('create', [
                    $this->empRepo->newInstance(),
                    $user
                ]);

            // si no esta creado o actualizando
            // probablemente es un error externo.
            default:
                throw new HttpException(500, 'Request con metodo invalido.');
        }
    }

    /**
     * Obtiene las reglas de validacion que seran aplicadas a esta peticion.
     * @return array<string, string>
     */
    public function rules()
    {
        // necesitamos saber que regla la cedula tendra
        $ciRules = $this->getCiRule();

        $genericRules = [
            'first_name'     => 'required|required|regex:/^[a-zA-Z-_áéíóúÁÉÍÓÚÑñ\']+$/|between:3,20',
            'last_name'      => 'regex:/^[a-zA-Z-_áéíóúÁÉÍÓÚÑñ\']+$/|between:3,20',
            'first_surname'  => 'required|required|regex:/^[a-zA-Z-_áéíóúÁÉÍÓÚÑñ\']+$/|between:3,20',
            'last_surname'   => 'regex:/^[a-zA-Z-_áéíóúÁÉÍÓÚÑñ\']+$/|between:3,20',
            'phone'          => 'max:15',
            'cellphone'      => 'max:15',
            'gender_id'      => 'numeric',
            'nationality_id' => 'required_with:identity_card|numeric',
        ];

        // unimos las reglas genericas con las de la cedula
        return array_merge($ciRules, $genericRules);
    }

    /**
     * Regresa las reglas relacionadas a la cedula de identidad
     * @return array<string, string>
     */
    private function getCiRule()
    {
        // debido a que la cedula es unica se hace la regla
        // sin embargo al actualizar, es necesario que
        // ignore la ya existente
        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                return [
                    'ci' => 'numeric|between:999999,99999999|unique:employees,ci,'
                        . (int) $this->route('employees'),
                ];

            case 'POST':
            default:
                return [
                    'ci' => 'numeric|between:999999,99999999|unique:employees',
                ];
        }
    }
}
