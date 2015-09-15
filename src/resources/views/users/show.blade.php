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
                    Perfil <small>{{$user->profile->desc}}</small>
                </h2>

                @if(!$user->employee)
                    <h1>
                        --
                    </h1>

                    @if(!Auth::user()->isAdmin())
                        <h2>
                            --
                        </h2>
                        <h3>
                            --
                        </h3>

                        <h4>
                            Usuario creado
                            {{$user->created_at->diffForHumans()}}
                            <small>{{$user->created_at}}</small>
                            <br/>
                            Por {{$user->createdBy()}}
                        </h4>

                        @unless(false)
                            <h4>
                                Usuario actualizado
                                {{$user->updated_at->diffForHumans()}}
                                <small>{{$user->updated_at}}</small>
                                <br/>
                                Por {{$user->updatedBy()}}
                            </h4>
                        @endunless
                    @endif
                @endif
            </div>

            {{-- pedidos --}}
            <div class="col-sm-6">
                <h1>Ultimos Pedidos generados</h1>
            </div>
        </div>
    </div>
@stop
