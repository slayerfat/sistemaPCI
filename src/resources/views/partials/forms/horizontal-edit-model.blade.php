<div class="container">
    <?php
    $defaults = [
        'route'  => isset($route) ? $route : ["{$resource}.update", $model->id],
        'method' => 'PATCH'
    ];

    if (isset($attributes)) {
        $attributes = array_merge($defaults, $attributes);
    } else {
        $attributes = $defaults;
    }

    if (!isset($spinner)) {
        $spinner = false;
    }
    ?>
    {!!

    BSForm::horizontalModel(
        $model,
        $attributes
    )

    !!}

    <legend>{{trans("models.{$resource}.edit")}}</legend>

    @include("{$resource}.partials.form", ['btnMsg' => trans("models.{$resource}.edit")])

    {!! BSForm::close() !!}
</div>

@section('js')
    @if($spinner)
        <script>
            var largeSpinner = new Forms.LargeAjaxSpinner($('body'));
            largeSpinner.onSubmit();
        </script>
    @endif
    @yield('form-js')
@stop
