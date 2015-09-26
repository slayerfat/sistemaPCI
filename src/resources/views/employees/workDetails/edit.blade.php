@extends('master')

@section('content')
    @include('partials.errors')

    <div class="container">
        {!!

            BSForm::horizontalModel(
                $workDetail,
                [
                    'route' => ['workDetails.update', $workDetail->id],
                    'method' => 'PATCH'
                ]
            )

        !!}

        <legend>{{trans('models.workDetails.edit')}}</legend>

        @include('employees.workDetails.partials.form', ['btnMsg' => trans('models.workDetails.edit')])

        {!! BSForm::close() !!}
    </div>
@stop
