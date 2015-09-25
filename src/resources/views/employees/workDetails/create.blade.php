@extends('master')

@section('content')
    @include('partials.errors')

    <div class="container">
        {!! BSForm::horizontalModel($workDetail, ['route' => ['workDetails.store', $user->name]]) !!}

        <legend>{{trans('models.workDetails.create')}}</legend>

        @include('workDetails.partials.form', ['btnMsg' => trans('models.workDetails.create')])

        {!! BSForm::close() !!}
    </div>
@stop
