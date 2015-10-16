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

                <hr/>

                @include('users.partials.showEmployee')

                <hr/>

                @include('users.partials.showWorkDetail')
            </div>

            {{-- pedidos --}}
            <div class="col-sm-4">
                <h1>Últimos Pedidos</h1>
                @foreach($user->petitions()->latest() as $petition)
                    <section class="user-petitions">
                        <h1>
                            <a href="{{ route('petitions.show', $petition->id) }}">
                                Nº {{ $petition->id }} | {{ $petition->formattedStatus }}
                            </a>
                        </h1>
                        @include('petitions.partials.items')
                    </section>
                @endforeach
            </div>
        </div>
    </div>
@stop
