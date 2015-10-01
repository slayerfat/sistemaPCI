@extends('master')

@section('content')
    @include('partials.errors')

    @include('partials.forms.horizontal-create-model', [
        'model'    => $employee,
        'resource' => 'employees',
        'route'    => ['employees.store', $user->name]
    ])
@stop
