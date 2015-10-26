{!!

ControlGroup::generate(
    BSForm::label('item_type_id', 'Tipo de Item'),
    BSForm::select('item_type_id', $itemTypes),
    BSForm::help('&nbsp;'),
    2
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('maker_id', 'Fabricante'),
    BSForm::select('maker_id', $makers),
    BSForm::help('&nbsp;'),
    2
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('sub_category_id', 'Rubro'),
    BSForm::select('sub_category_id', $subCats),
    BSForm::help('&nbsp;'),
    2
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('stock_type_id', 'Tipo de Cantidad'),
    BSForm::select('stock_type_id', $stockTypes),
    BSForm::help('El tipo por defecto, necesario para operaciones aritmeticas.'),
    2
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('asoc', 'Tipo de Asociacion'),
    BSForm::select('asoc', ['a' => 'A', 'b' => 'B', 'c' => 'C']),
    BSForm::help("Tipo de asociacion de la Metodologia 'ABC'."),
    2
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('priority', 'Prioridad'),
    BSForm::number('priority'),
    BSForm::help('En procentaje.'),
    2
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('desc', 'Nombre o Descripcion'),
    BSForm::text('desc'),
    BSForm::help('&nbsp;'),
    2
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('minimum', 'Stock Minimo'),
    BSForm::number('minimum'),
    BSForm::help("El Stock minimo que se debe mantener, util para calculos 'ABC'."),
    2
)

!!}

{!! Button::primary($btnMsg)->block()->submit() !!}
