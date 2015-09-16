@extends('master')

@section('content')

    @include('partials.genericTable', ['data' => $users])

@stop
