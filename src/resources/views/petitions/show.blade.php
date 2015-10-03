@extends('master')

@section('content')
    <div class="container">
        <h1>
            {{$petition}}
        </h1>

        @include('partials.admins.show-basic-audit', [
            'model'    => $petition,
            'created'  => trans('models.petitions.singular') . ' creado',
            'updated'  => trans('models.petitions.singular') . ' actualizado',
        ])
    </div>
@stop
