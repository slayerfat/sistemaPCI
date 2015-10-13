@extends('master')

@section('content')
    <div class="container">
        <h1>
            {{ trans('models.petitions.singular') }}
            #{{ $petition->id }}

            <small>
                <a href="{{ route('users.show', $petition->user->name) }}">
                    Solicitado por {{ $petition->user->name }}
                </a>
                {!! Html::mailto($petition->user->email) !!}
            </small>
        </h1>

        <h2>
            Este {{ trans('models.petitions.singular') }}
            es de tipo {{ $petition->type->desc }}.
        </h2>

        @include('petitions.partials.status')
        @include('petitions.partials.items')

        <hr>

        <h4 class="well">
            {{ $petition->comments }}
        </h4>

        {{-- TODO: notas --}}

        @include('partials.admins.show-basic-audit', [
            'model'    => $petition,
            'created'  => trans('models.petitions.singular') . ' creado',
            'updated'  => trans('models.petitions.singular') . ' actualizado',
        ])
    </div>
@stop
