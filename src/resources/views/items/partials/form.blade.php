{!!

ControlGroup::generate(
    BSForm::label('item_type_id', 'Tipo de Item'),
    // solamente un array con dos elementos
    // porque solo hay 2 almacenes en fisico.
    BSForm::select('item_type_id', $itemTypes),
    BSForm::help('&nbsp;'),
    2
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('maker_id', 'Fabricante'),
    // solamente un array con dos elementos
    // porque solo hay 2 almacenes en fisico.
    BSForm::select('maker_id', $makers),
    BSForm::help('&nbsp;'),
    2
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('sub_category_id', 'Rubro'),
    // solamente un array con dos elementos
    // porque solo hay 2 almacenes en fisico.
    BSForm::select('sub_category_id', $subCats),
    BSForm::help('&nbsp;'),
    2
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('asoc', 'Tipo de Asociacion'),
    // solamente un array con dos elementos
    // porque solo hay 2 almacenes en fisico.
    BSForm::select('asoc', ['a' => 'A', 'b' => 'B', 'c' => 'C']),
    BSForm::help("Tipo de asociacion de la Metodologia 'ABC'."),
    2
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('priority', 'Prioridad'),
    // solamente un array con dos elementos
    // porque solo hay 2 almacenes en fisico.
    BSForm::number('priority'),
    BSForm::help('En procentaje.'),
    2
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('desc', 'Nombre o Descripcion'),
    // solamente un array con dos elementos
    // porque solo hay 2 almacenes en fisico.
    BSForm::number('desc'),
    BSForm::help('En procentaje.'),
    2
)

!!}

!!}

{!!

ControlGroup::generate(
    BSForm::label('stock', 'Stock inicial'),
    // solamente un array con dos elementos
    // porque solo hay 2 almacenes en fisico.
    BSForm::number('stock'),
    BSForm::help('La cantidad actual en existencia.'),
    2
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('minimum', 'Stock Minimo'),
    // solamente un array con dos elementos
    // porque solo hay 2 almacenes en fisico.
    BSForm::number('minimum'),
    BSForm::help("El Stock minimo que se debe mantener, util para calculos 'ABC'."),
    2
)

!!}

{!! Button::primary($btnMsg)->block()->submit() !!}
