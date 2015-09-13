@extends('emails.master')

@section('content')
    <section style="color: #333;font-family: sans-serif;">
        <h1>Bienvenido a {{ trans('defaults.appName') }}!</h1>

        <h3>Hola {{ $user->name }}!</h3>
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
    </section>
@stop
