<?php namespace PCI\Http\Requests\User;

use Illuminate\Auth\Guard;
use PCI\Http\Requests\Request;
use PCI\Models\Employee;
use PCI\Models\User;
use PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface;

class CreateEmployeeRequest extends Request
{

    /**
     * @var \PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface
     */
    private $empRepo;

    /**
     * @var \Illuminate\Auth\Guard
     */
    private $auth;

    /**
     * Genera la instancia del user request dandole el repositorio de usuarios.
     * @param \PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface $empRepo
     * @param \Illuminate\Auth\Guard $auth
     */
    public function __construct(EmployeeRepositoryInterface $empRepo, Guard $auth)
    {
        parent::__construct();

        $this->empRepo = $empRepo;
        $this->auth = $auth;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->empRepo->findUser($this->route('users'));

        /** @var User $currentUser */
        $currentUser = $this->auth->user();

        return $currentUser
            ->can('create', Employee::class, $user);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
