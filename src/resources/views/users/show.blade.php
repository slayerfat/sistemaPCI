@extends('master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('users.partials.sidebar', ['active' => '.show'])

            {{-- user info --}}
            <div class="{{ $user->petitions->isEmpty() ? 'col-sm-10' : 'col-sm-4'}}">
                <h1>
                    {{$user->name}}

                    <small>{!! Html::mailto($user->email) !!}</small>
                </h1>

                <h2>
                    Perfil <small>{{$user->profile->desc}}</small>
                </h2>

                <hr/>

                @include('users.partials.showEmployee')

                <hr/>

                @include('users.partials.showWorkDetail')
            </div>

            @if (!$user->petitions->isEmpty())
                <div class="col-sm-6">
                    @include('users.partials.petitions-table')
                </div>
            @endif
        </div>
    </div>
@stop
