<?php

namespace PCI\Http\Controllers\Auth;

use Event;
use Flash;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Validation\ValidatesRequests;
use PCI\Events\NewUserRegistration;
use PCI\Http\Controllers\Controller;
use PCI\Models\User;
use Validator;

/**
 * Class AuthController
 * @package PCI\Http\Controllers\Auth
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins, ValidatesRequests;

    /**
     * el campo en la tabla usuario que es el seudonimo
     * (overwrites email como default)
     *
     * @var string
     */
    protected $username = 'name';

    /**
     * AuthenticatesAndRegistersUsers
     * @redirectPath()
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * path de redireccionamiento cuando
     * autenticacion falla en postLogin y otros.
     *
     * @var string
     */
    protected $loginPath = 'sesion/iniciar';

    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|max:20|alpha-dash|unique:users',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = new User;

        $user->profile_id        = User::DISABLED_ID;
        $user->name              = $data['name'];
        $user->email             = $data['email'];
        $user->password          = bcrypt($data['password']);
        $user->confirmation_code = str_random(32);

        $user->save();

        Event::fire(new NewUserRegistration($user));

        Flash::info(
            'Usuario creado exitosamente, un correo de confirmación '
            .'ha sido enviado a '
            .$user->email
        );

        return $user;
    }
}
