@extends('master')

@section('content')
    @include('partials.errors')

    <div class="container">
        {!! BSForm::horizontalModel($employee, ['route' => 'employees.store']) !!}

        <legend>{{trans('models.employees.create')}}</legend>

        @include('employees.partials.form', ['btnMsg' => 'Crear Usuario'])

        {!! BSForm::close() !!}
    </div>
@stop
