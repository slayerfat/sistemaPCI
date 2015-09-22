{!!

ControlGroup::generate(
    BSForm::label('first_name', 'Primer nombre'),
    BSForm::text('first_name'),
    BSForm::help('&nbsp;'),
    3
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('last_name', 'Segundo nombre'),
    BSForm::text('last_name'),
    BSForm::help('&nbsp;'),
    3
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('first_surname', 'Primer apellido'),
    BSForm::text('first_surname'),
    BSForm::help('&nbsp;'),
    3
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('last_surname', 'Segundo apellido'),
    BSForm::text('last_surname'),
    BSForm::help('&nbsp;'),
    3
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('ci', 'Cedula de identidad'),
    BSForm::text('ci'),
    BSForm::help('Sin letras o Caracteres especiales ej: 21879654'),
    3
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('phone', 'Telefono'),
    BSForm::text('phone'),
    BSForm::help('Sin letras o Caracteres especiales ej: 21879654'),
    3
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('cellphone', 'Telefono celular'),
    BSForm::text('cellphone'),
    BSForm::help('Sin letras o Caracteres especiales ej: 21879654'),
    3
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('gender_id', 'Genero'),
    BSForm::select('gender_id', $genders),
    BSForm::help('&nbsp;'),
    3
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('nacionality_id', 'Nacionalidad'),
    BSForm::select('nacionality_id', $nats),
    BSForm::help('&nbsp;'),
    3
)

!!}

{!! Button::primary($btnMsg)->block()->submit() !!}
