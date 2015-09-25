<?php namespace PCI\Http\Controllers\Auth;

use Event;
use Flash;
use Illuminate\Auth\Guard;
use PCI\Events\ConfirmationCodeRequest;
use PCI\Http\Controllers\Controller;
use PCI\Repositories\Interfaces\User\UserRepositoryInterface;
use Redirect;

/**
 * Class UserConfirmationController
 * @package PCI\Http\Controllers\Auth
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class UserConfirmationController extends Controller
{

    /**
     * La implementacion de Guard que contiene al usuario.
     * @var Guard
     */
    private $auth;

    /**
     * El repositorio de usuarios.
     * @var UserRepositoryInterface
     */
    private $userRepo;

    /**
     * Construye una nueva instancia, esta depende
     * del Guard y el repositorio de usuarios.
     * @param Guard $auth
     * @param \PCI\Repositories\Interfaces\User\UserRepositoryInterface $userRepo
     */
    public function __construct(Guard $auth, UserRepositoryInterface $userRepo)
    {
        $this->auth = $auth;
        $this->userRepo = $userRepo;
    }

    /**
     * Chequea el codigo y redireciona segun el repo.
     * @param string $code el codigo en 32 caracteres.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirm($code)
    {
        if (!$code) {
            return Redirect::route('index');
        }

        if (!$this->userRepo->confirmCode($code)) {
            return Redirect::route('index');
        }

        $this->auth->logout();

        Flash::success('Ud. ha verificado exitosamente su cuenta.');

        return Redirect::route('auth.getLogin');
    }

    /**
     * Si el usuario no tiene o necesita un
     * nuevo codigo, este es generado aqui.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        $user = $this->userRepo->generateConfirmationCode();

        Event::fire(new ConfirmationCodeRequest($user));

        Flash::info(
            'Nueva confirmación generada y enviada a '
            .$user->email
            .', por favor revise su correo electronico.'
        );

        return Redirect::route('index.unverified');
    }
}
