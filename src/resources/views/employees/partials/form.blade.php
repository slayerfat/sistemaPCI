{!!

ControlGroup::generate(
    BSForm::label('name', 'Seudónimo'),
    BSForm::text('name'),
    BSForm::help('&nbsp;'),
    2
)

!!}

{!! Button::primary($btnMsg)->block()->submit() !!}
