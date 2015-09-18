@extends('master')

@section('content')

    @include('partials.errors')

    <div class="container">
        {!! BSForm::horizontalModel($variables->getModel(), ['route' => $variables->getDestView()]) !!}

        <legend>{{$variables->getUsersGoal()}}</legend>

        @include('aux.form', ['btnMsg' => $variables->getUsersGoal()])

        {!! BSForm::close() !!}
    </div>

@stop
