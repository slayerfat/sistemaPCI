@extends('master')

@section('content')
<div class="jumbotron">
    <div class="container">
        <h1>sistemaPCI</h1>

        @if(auth()->user()->isAdmin())
            @include('partials.users.recap')
        @else
            @include('partials.users.recap')
        @endif
    </div>
</div>
@stop
