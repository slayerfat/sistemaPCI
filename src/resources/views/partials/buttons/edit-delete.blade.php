{!!

Button::withValue('Editar')
    ->asLinkTo(route("{$resource}.edit", $id))
    ->withIcon(Icon::create('edit'))
    ->withAttributes(['id' => "model-edit-{$id}", 'class' => 'btn-info'])

!!}

{!!

Button::danger('Eliminar')
    ->asLinkTo('#')
    ->withIcon(Icon::create('trash-o'))
    ->withAttributes([
        'onClick' => "deleteResourceFromAnchor($id)",
        'id'      => "model-delete-{$id}"
    ])

!!}

{!! Form::open(['route' => ["{$resource}.destroy", $id], 'method' => 'DELETE', 'id' => $id]) !!}

{!! Form::close() !!}
