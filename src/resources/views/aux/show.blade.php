@extends('master')

{{--{!!dd($variables)!!}--}}

@section('content')
    @if(Auth::user() and Auth::user()->isAdmin())
        <div class="container">
            <div class="row">
                <div class="col-xs-2">
                    <a
                        href="{{route($variables->getRoutes()->edit, $variables->getModel()->id)}}"
                        class="btn btn-default btn-block"
                        >
                        Editar
                    </a>
                </div>
                <div class="col-xs-2">
                    {!! Form::open(['method' => 'DELETE', 'route' => [$variables->getRoutes()->destroy, $variables->getModel()->id]]) !!}
                    {!! Form::submit('Eliminar', ['class' => 'btn btn-danger btn-block', 'onclick' => 'deleteResourceConfirm()']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1>{{$variables->getModel()->desc}}</h1>
                @if($variables->getParent())
                    <h2>{{$variables->getParent()->count()}}</h2>
                @endif
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{!! asset('js/show/deleteResourceConfirm.js') !!}"></script>
@stop
