<?php namespace PCI\Http\Requests\User;

use PCI\Http\Requests\Request;
use PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface;

class UpdateEmployeeRequest extends Request
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
     */
    public function authorize()
    {
        $employee = $this->empRepo->find($this->route('employees'));

        return $this->user()->can('update', $employee);
    }

    /**
     * Obtiene las reglas de validacion que seran aplicadas a esta peticion.
     * @return array
     */
    public function rules()
    {
        return [
            'ci'             => 'numeric|between:999999,99999999|unique:employees,ci,' . (int) $this->route('employees'),
            'first_name'     => 'required|string|max:20',
            'last_name'      => 'string|max:20',
            'first_surname'  => 'required|string|max:20',
            'last_surname'   => 'string|max:20',
            'phone'          => 'max:15',
            'cellphone'      => 'max:15',
            'gender_id'      => 'numeric',
            'nationality_id' => 'required_with:identity_card|numeric',
        ];
    }
}
