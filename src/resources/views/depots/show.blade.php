@extends('master')

@section('content')
    <div class="container">
        <h1>
            {{trans('models.depts.singular')}}
            {{$depot->number}}

            @include(
                'partials.buttons.edit-delete',
                ['resource' => 'depots', 'id' => $depot->id]
            )
        </h1>

        <h2>
            Administrador por
            <a href="{{route('users.show', $depot->owner->name)}}">
                {{$depot->owner->name}},
            </a>
            {!! Html::mailto($depot->owner->email) !!}
        </h2>

        <h3>
            Anaquel {{$depot->rack}}, Alacena {{$depot->shelf}}
        </h3>

        @include('depots.partials.items')

        @include('partials.admins.show-basic-audit', [
            'model'    => $depot,
            'created'  => trans('models.depots.singular') . ' creado',
            'updated'  => trans('models.depots.singular') . ' actualizado',
        ])
    </div>
@stop
