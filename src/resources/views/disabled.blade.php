@extends('master')

@section('content')
    <div class="container">
        <h1>
            Hola! {{ $user->name }}!
        </h1>

        <h3 class="text-justify">
            Para poder entrar en el sistema, es necesario que Usted. valide su
            cuenta con el correo ya enviado. Es recomendable esperar unos minutos,
            <small>(usualmente es instantaneo).</small>
            Si no ha recibido nada, por favor cheque en los correos no deseados de su correo,
            o spam <small>(y tambien aproveche de poner nuestro correo como uno que Ud. confia).</small>
        </h3>

        <h4>
            Si ha seguido estos pasos o borro sin querer el susodicho correo, puede generar
            <strong>
                {!! link_to_route('users.confirmations.create', 'Una nueva Verificacion.') !!}
            </strong>
        </h4>
    </div>
@stop
