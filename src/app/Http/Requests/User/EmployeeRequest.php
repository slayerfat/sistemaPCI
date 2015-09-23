<?php namespace PCI\Http\Requests\User;

use PCI\Http\Requests\Request;
use PCI\Models\Employee;
use PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $employee = $this->empRepo->find($this->route('employees'));

                return $this->user()->can('update', $employee);

            case 'POST':
                $user = $this->empRepo->findParent($this->route('users'));

                return $this->user()->can('create', [Employee::class, $user]);

            default:
                throw new HttpException(500, 'Request con metodo invalido.');
        }
    }

    /**
     * Obtiene las reglas de validacion que seran aplicadas a esta peticion.
     * @return array
     */
    public function rules()
    {
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

        return array_merge($ciRules, $genericRules);
    }

    /**
     * Regresa las reglas relacionadas a la cedula de identidad
     * @return array
     */
    private function getCiRule()
    {
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
