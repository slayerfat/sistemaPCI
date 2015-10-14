@extends('emails.master')

@section('content')
<div style="width: 90%;">
    <section style="color: #333;font-family: sans-serif;">
        <h1>El usuario {{$user->name}} {!! Html::mailto($user->email) !!}.</h1>
    </section>
    <section style="color: #333;font-family: sans-serif;">
        <p>
            Ha solicitado la aprobación del
            {{ trans('models.petitions.singular') }} #{{ $petition->id }}.
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
        @include('emails.petitions.partials.comments')
        @include('emails.petitions.partials.timestamp')
    </section>
</div>
@stop
