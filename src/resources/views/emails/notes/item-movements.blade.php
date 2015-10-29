@extends('emails.master')

@section('content')
<div style="width: 90%;">
    <section style="color: #333;font-family: sans-serif;">
        <h1>Hola {{$user->name}}!</h1>
    </section>
    <section style="color: #333;font-family: sans-serif;">
        <p>
            Del {{ trans('models.petitions.singular') }} #{{ $petition->id }}
            que generó la {{ trans('models.notes.singular') }}
            #{{ $note->id }}, desencadenó el
            {{ trans('models.movements.singular') }} #{{ $movement->id }}.
        </p>
        <p>
            Para ver este {{ trans('models.petitions.singular') }}, Ud.
            puede visitar el siguiente enlace:
            <a href="{!! route('petitions.show', $petition->id) !!}">
                {!! route('petitions.show', $petition->id) !!}
            </a>
        </p>

        <p>
            Para ver esta {{ trans('models.notes.singular') }}, Ud.
            puede visitar el siguiente enlace:
            <a href="{!! route('notes.show', $note->id) !!}">
                {!! route('notes.show', $note->id) !!}
            </a>
        </p>

        <p>
            El documento relacionado ha sido generado y puede descargarlo
            en el siguiente enlace:
            <a href="{!! route('api.movements.pdf', $movement->id) !!}">
                {!! route('api.movements.pdf', $movement->id) !!}
            </a>
        </p>

        <aside>
            <h1>
                Detalles del {{ trans('models.movements.singular') }}
                #{{ $movement->id }}
            </h1>
            @include('emails.notes.partials.item-movements-table')
        </aside>

        <hr>

        <aside>
            <h1>
                Detalles de {{ trans('models.notes.singular') }}
                #{{ $note->id }}
            </h1>
            @include('emails.notes.partials.item-table')
            @include('emails.notes.partials.comments')
        </aside>

        <aside>
            <h1>
                Detalles de {{ trans('models.petitions.singular') }}
                #{{ $petition->id }}
            </h1>
            @include('emails.petitions.partials.item-table')
            @include('emails.petitions.partials.comments')
        </aside>

        @include('emails.petitions.partials.timestamp')
    </section>
</div>
@stop
