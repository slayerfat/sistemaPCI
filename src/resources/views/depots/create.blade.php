@extends('master')

@section('content')
    @include('partials.errors')

    <div class="container">
        {!! BSForm::horizontalModel($depot, ['route' => 'depots.store']) !!}

        <legend>{{trans('models.depots.create')}}</legend>

        @include('depots.partials.form', ['btnMsg' => trans('models.depots.create')])

        {!! BSForm::close() !!}
    </div>
@stop
