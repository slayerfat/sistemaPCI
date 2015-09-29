{!!

Button::withValue('Editar')
        ->asLinkTo(route("{$resource}.edit", $id))
        ->withIcon(Icon::create('edit'))

!!}

{!!

Button::danger('Eliminar')
        ->asLinkTo('#')
        ->withIcon(Icon::create('trash-o'))
        ->withAttributes(['onClick' => "deleteResourceFromAnchor($id)"])

!!}

{!! Form::open(['route' => ["{$resource}.destroy", $id], 'method' => 'DELETE', 'id' => $id]) !!}

{!! Form::close() !!}
