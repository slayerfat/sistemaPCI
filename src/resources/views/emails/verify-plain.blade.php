*******************************************************************
Bienvenido a {{ trans('defaults.appName') }}!
*******************************************************************

Para poder ingresar a
{!! link_to_route('index', trans('defaults.appName')) !!}

Ud. debe confirmar su cuenta a travez del siguiente enlace:

*******************************************************************

{!! route('auth.confirm', $confirmation_code) !!}

*******************************************************************
