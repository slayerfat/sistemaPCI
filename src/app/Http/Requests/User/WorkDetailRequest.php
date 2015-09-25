<?php namespace PCI\Http\Requests\User;

use PCI\Http\Requests\Request;
use PCI\Repositories\Interfaces\User\WorkDetailRepositoryInterface;

/**
 * Class WorkDetailRequest
 * @package PCI\Http\Requests\User
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class WorkDetailRequest extends Request
{

    /**
     * La implementacion del empleado.
     * @var \PCI\Repositories\Interfaces\User\WorkDetailRepositoryInterface
     */
    private $repo;

    /**
     * Genera la instancia del user request dandole el repositorio de usuarios.
     * @param \PCI\Repositories\Interfaces\User\WorkDetailRepositoryInterface $repo
     */
    public function __construct(WorkDetailRepositoryInterface $repo)
    {
        parent::__construct();

        $this->repo = $repo;
    }

    /**
     * Determina si el usuario esta autorizado a hacer esta peticion.
     * @return bool
     */
    public function authorize()
    {
        // necesitamos saber que tipo de request es, si el tipo de request
        // es post, entonces se pretende crear, por lo tanto se
        // chequea que el usuario relacionado con el empleado
        // sea valido en comparacion con el usuario actual.
        if ($this->isMethod('POST')) {
            $employee = $this->repo->findParent($this->route('employees'));

            return $this->user()
                        ->can('create', [
                            $this->repo->newInstance(),
                            $employee
                        ]);
        }

        // si se esta actualizando, se chequea con los datos del modelo.
        $workDetail = $this->repo->find($this->route('workDetails'));

        return $this->user()->can('update', $workDetail);
    }

    /**
     * Obtiene las reglas de validacion que seran aplicadas a esta peticion.
     * @return array<string, string>
     */
    public function rules()
    {
        return [
            'department_id'  => 'numeric',
            'position_id'    => 'numeric',
            'employee_id'    => 'required|numeric',
            'join_date'      => 'date',
            'departure_date' => 'numeric',
        ];
    }
}
