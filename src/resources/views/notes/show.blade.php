@extends('master')

@section('content')
    <div class="container">
        <h1>
            {{ trans('models.notes.singular') }}
            #{{ $note->id }}

            <small>
                <a href="{{ route('users.show', $note->user->name) }}">
                    Creado por {{ $note->user->name }}
                </a>
                {!! Html::mailto($note->user->email) !!}
            </small>

            @include('notes.partials.show-buttons')
        </h1>

        <h2>
            Este {{ trans('models.notes.singular') }}
            es de tipo {{ $note->type->desc }}.
        </h2>

        <h3>
            <small>
                <a href="{{ route('users.show', $note->toUser->name) }}">
                    Dirigido a {{ $note->toUser->name }}
                </a>
                {!! Html::mailto($note->toUser->email) !!}
            </small>
        </h3>

        @include('notes.partials.status')
        @include('notes.partials.items')

        <hr>

        <h4 class="well">
            {{ $note->comments }}
        </h4>

        {{-- TODO: notas --}}

        @include('partials.admins.show-basic-audit', [
            'model'    => $note,
            'created'  => trans('models.notes.singular') . ' creada',
            'updated'  => trans('models.notes.singular') . ' actualizada',
        ])
    </div>
@stop

@section('js')
    @yield('js-buttons')
    @yield('js-show-buttons')
@stop
