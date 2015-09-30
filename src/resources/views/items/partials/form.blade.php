{!!

ControlGroup::generate(
    BSForm::label('&nbsp;', '&nbsp;'),
    // solamente un array con dos elementos
    // porque solo hay 2 almacenes en fisico.
    BSForm::text('&nbsp;'),
    BSForm::help('&nbsp;'),
    2
)

!!}

{!! Button::primary($btnMsg)->block()->submit() !!}
