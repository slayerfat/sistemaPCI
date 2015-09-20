<?php namespace PCI\Http\Controllers\Auth;

use Event;
use Flash;
use Redirect;
use Illuminate\Auth\Guard;
use PCI\Http\Controllers\Controller;
use PCI\Events\ConfirmationCodeRequest;
use PCI\Repositories\Interfaces\User\UserRepositoryInterface;

class UserConfirmationController extends Controller
{

    /**
     * @var Guard
     */
    private $auth;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepo;

    /**
     * @param Guard $auth
     * @param \PCI\Repositories\Interfaces\User\UserRepositoryInterface $userRepo
     */
    public function __construct(Guard $auth, UserRepositoryInterface $userRepo)
    {
        $this->auth = $auth;
        $this->userRepo = $userRepo;
    }

    /**
     * @param $code
     * @return \Illuminate\Http\RedirectResponse;
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
     * @return \Illuminate\Http\RedirectResponse;
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
