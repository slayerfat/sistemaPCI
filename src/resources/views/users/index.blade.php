@extends('master')

@section('content')

    @include('partials.genericTable', [
        'data' => $users,
        'title' => 'Usuarios en el sistema'
    ])

@stop
