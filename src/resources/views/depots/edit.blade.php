@extends('master')

@section('content')
    @include('partials.errors')

    <div class="container">
        {!!

        BSForm::horizontalModel(
            $depot,
            [
                'route' => ['depots.update', $depot->id],
                'method' => 'PATCH'
            ]
        )

        !!}

        <legend>{{trans('models.depots.edit')}}</legend>

        @include('depots.partials.form', ['btnMsg' => trans('models.depots.edit')])

        {!! BSForm::close() !!}
    </div>
@stop
