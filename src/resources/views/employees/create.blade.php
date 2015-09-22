@extends('master')

@section('content')
    @include('partials.errors')

    <div class="container">
        {!! BSForm::horizontalModel($employee, ['route' => ['employees.store', $user->name]]) !!}

        <legend>{{trans('models.employees.create')}}</legend>

        @include('employees.partials.form', ['btnMsg' => trans('models.employees.create')])

        {!! BSForm::close() !!}
    </div>
@stop
