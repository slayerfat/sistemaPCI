@extends('emails.master')

@section('content')
    <section style="color: #333;font-family: sans-serif;">
        <h1>Hola {{ $user->name }}!</h1>
    </section>
    <section style="color: #333;font-family: sans-serif;">
        <p id="body" style="text-align: justify;">
            Para poder ingresar a
            {!! link_to_route('index', trans('defaults.appName')) !!}
            Ud. debe confirmar su cuenta a travez del siguiente enlace:
        </p>
        <p>
            <?php $url = route('auth.confirm', $user->confirmation_code) ?>
            <a href="{{ $url }}">{{ $url }}</a>
        </p>

        <p>
            Mensaje generado el {!! Date::now()->format('l j F Y H:i:s') !!}
        </p>
    </section>
@stop
