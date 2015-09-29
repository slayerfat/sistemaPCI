{!!

ControlGroup::generate(
    BSForm::label('number', 'Almacen N°'),
    // solamente un array con dos elementos
    // porque solo hay 2 almacenes en fisico.
    BSForm::select('number', [1, 2]),
    BSForm::help('&nbsp;'),
    2
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('rack', 'Anaquel'),
    BSForm::number('rack'),
    BSForm::help('&nbsp;'),
    2
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('shelf', 'Alacena'),
    BSForm::number('shelf'),
    BSForm::help('&nbsp;'),
    2
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('user_id', 'Jefe de Almacen'),
    BSForm::select('user_id', $admins->lists('email', 'id')),
    BSForm::help('&nbsp;'),
    2
)

!!}

{!! Button::primary($btnMsg)->block()->submit() !!}
