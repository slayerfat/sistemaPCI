@extends('master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('users.partials.sidebar', ['active' => '.show'])

            {{-- user info --}}
            <div class="col-sm-4">
                <h1>
                    {{$user->name}}

                    <small>{!! Html::mailto($user->email) !!}</small>
                </h1>

                <h2>
                    <small>{{$user->profile->description}}</small>
                </h2>

                @if(Auth::user()->isAdmin() && $user->employee)
                    <h2>
                        --
                    </h2>
                    <h3>
                        --
                    </h3>
                @endif
            </div>

            {{-- pedidos --}}
            <div class="col-sm-6">
                <h1>Ultimos Pedidos generados</h1>
            </div>
        </div>
    </div>
@stop
