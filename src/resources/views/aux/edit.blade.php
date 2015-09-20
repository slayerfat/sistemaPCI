@extends('master')

@section('content')

    @include('partials.errors')

    <div class="container">
        {!!

        BSForm::horizontalModel(
            $variables->getModel(),
            [
                'route' => [$variables->getRoutes()->update, $variables->getModel()->id],
                'method' => 'PATCH'
            ]
        )

        !!}

        <legend>{{$variables->getUsersGoal()}}</legend>

        @include('aux.form', ['btnMsg' => $variables->getUsersGoal()])

        {!! BSForm::close() !!}
    </div>

@stop
