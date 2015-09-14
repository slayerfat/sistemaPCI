*******************************************************************
Hola {{ $user->name }}!
*******************************************************************
Para poder ingresar a
{!! link_to_route('index', trans('defaults.appName')) !!}

Ud. debe confirmar su cuenta a travez del siguiente enlace:
*******************************************************************
{!! route('auth.confirm', $user->confirmation_code) !!}
*******************************************************************
Mensaje generado el {!! Date::now()->format('l j F Y H:i:s') !!}
*******************************************************************

