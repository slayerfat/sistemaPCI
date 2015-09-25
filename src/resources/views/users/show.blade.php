@extends('master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('users.partials.sidebar', ['active' => '.show'])

            {{-- user info --}}
            <div class="col-sm-6">
                <h1>
                    {{$user->name}}

                    <small>{!! Html::mailto($user->email) !!}</small>
                </h1>

                <h2>
                    Perfil <small>{{$user->profile->desc}}</small>
                </h2>

                @include('users.partials.showEmployee')
                @include('users.partials.showWorkDetail')
            </div>

            {{-- pedidos --}}
            <div class="col-sm-4">
                <h1>Ultimos Pedidos</h1>
            </div>
        </div>
    </div>
@stop
