<?php namespace PCI\Http\Controllers\Auth;

use Flash;
use Illuminate\Auth\Guard;
use Redirect;
use PCI\Models\User;
use PCI\Http\Controllers\Controller;

class UserConfirmationController extends Controller
{

    /**
     * @var Guard
     */
    private $auth;

    /**
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
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

        $user = User::whereConfirmationCode($code)->first();

        if (!$user) {
            return Redirect::route('index');
        }

        $user->status            = true;
        $user->confirmation_code = null;
        $user->save();

        $this->auth->logout();

        Flash::success('Ud. ha verificado exitosamente su cuenta.');

        return Redirect::route('auth.getLogin');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse;
     */
    public function create()
    {


        Flash::info(
            'Nueva confirmación generada y enviada a '
            .$user->email
            .', por favor revise su correo electronico.'
        );

        return redirect('/');
    }
}
