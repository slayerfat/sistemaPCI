@extends('master')

@section('content')
    @include('partials.errors')

    <div class="container">
        {!!

            BSForm::horizontalModel(
                $employee,
                [
                    'route' => ['employees.update', $employee->id],
                    'method' => 'PATCH'
                ]
            )

        !!}

        <legend>{{trans('models.employees.edit')}}</legend>

        @include('employees.partials.form', ['btnMsg' => trans('models.employees.edit')])

        {!! BSForm::close() !!}
    </div>
@stop
