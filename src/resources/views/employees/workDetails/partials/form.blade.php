{!!

ControlGroup::generate(
    BSForm::label('join_date', 'Fecha de ingreso'),
    BSForm::text('join_date'),
    BSForm::help('&nbsp;'),
    3
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('departure_date', 'Fecha de egreso'),
    BSForm::text('departure_date'),
    BSForm::help('&nbsp;'),
    3
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('department_id', 'Departamento'),
    BSForm::select('department_id', $departments),
    BSForm::help('&nbsp;'),
    3
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('position_id', 'Cargo'),
    BSForm::select('position_id', $positions),
    BSForm::help('&nbsp;'),
    3
)

!!}

{!! Button::primary($btnMsg)->block()->submit() !!}
