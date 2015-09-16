<?php namespace PCI\Http\Requests;

use Gate;
use PCI\Repositories\Interfaces\UserRepositoryInterface;

class UserRequest extends Request
{

    /**
     * @var UserRepositoryInterface
     */
    private $userRepo;

    /**
     * Genera la instancia del user request dandole el repositorio de usuarios.
     * @param UserRepositoryInterface $userRepo
     */
    public function __construct(UserRepositoryInterface $userRepo)
    {
        parent::__construct();

        $this->userRepo = $userRepo;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'       => 'required|max:20|alpha-dash|unique:users',
            'email'      => 'required|email|max:255|unique:users',
            'password'   => 'required|confirmed|min:6',
            'profile_id' => 'required|numeric',
        ];
    }
}
