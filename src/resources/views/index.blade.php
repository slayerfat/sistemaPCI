@extends('master')

@section('content')

<div class="jumbotron">
    <div class="container">

        <h1>{{trans('defaults.appName')}}</h1>

        @if(auth()->user()->isAdmin())
            @include('partials.recaps.admins')
        @else
            @include('partials.recaps.users')
        @endif

    </div>
</div>

@stop
