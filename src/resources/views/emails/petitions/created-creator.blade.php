@extends('emails.master')

@section('content')
<div style="width: 90%;">
    <section style="color: #333;font-family: sans-serif;">
        <h1>Hola {{$user->name}}!</h1>
    </section>
    <section style="color: #333;font-family: sans-serif;">
        <p>
            Su {{ trans('models.petitions.singular') }} #{{ $petition->id }}
            Ha sido creado exitosamente, y ha sido despachado a las partes interesadas.
        </p>
        <p>
            Para ver este {{ trans('models.petitions.singular') }}, Ud.
            puede visitar el siguiente enlace:
        </p>

        <p>
            <a href="{!! route('petitions.show', $petition->id) !!}">
                {!! route('petitions.show', $petition->id) !!}
            </a>
        </p>

        @include('emails.petitions.partials.item-table')

        @include('emails.petitions.partials.timestamp')
    </section>
</div>
@stop
