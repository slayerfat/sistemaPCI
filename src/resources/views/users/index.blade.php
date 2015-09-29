@extends('master')

@section('content')

    @include('partials.genericTable', [
        'data' => $users,
        'title' => trans('models.users.plural')
    ])

@stop
