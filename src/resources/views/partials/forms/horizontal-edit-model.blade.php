<div class="container">
    {!!

    BSForm::horizontalModel(
        $model,
        [
            'route' => ["{$resource}.update", $model->id],
            'method' => 'PATCH'
        ]
    )

    !!}

    <legend>{{trans("models.{$resource}.edit")}}</legend>

    @include("{$resource}.partials.form", ['btnMsg' => trans("models.depots{$resource}.edit")])

    {!! BSForm::close() !!}
</div>
