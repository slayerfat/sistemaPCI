<?php namespace PCI\Http\Controllers\Auth;

use Flash;
use Illuminate\Auth\Guard;
use Redirect;
use PCI\Models\User;
use PCI\Http\Controllers\Controller;

class UserConfirmationController extends Controller
{

    /**
     * @param $code
     * @param Guard $auth
     * @return mixed
     */
    public function confirm($code, Guard $auth)
    {
        if (!$code) {
            abort(403);
        }

        $user = User::whereConfirmationCode($code)->first();

        if (!$user) {
            abort(403);
        }

        $user->status            = true;
        $user->confirmation_code = null;
        $user->save();

        $auth->logout();

        Flash::success('Ud. ha verificado exitosamente su cuenta.');

        return Redirect::route('auth.getLogin');
    }
}
