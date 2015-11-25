{!!

Button::withValue('Reporte General')
    ->asLinkTo(route("items.edit", $item->id))
    ->withIcon(Icon::create('file-pdf-o'))
    ->withAttributes(['id' => "item-report-{$item->id}"])

!!}

{!!

Button::withValue('Existencias')
    ->asLinkTo(route("items.edit", $item->id))
    ->withIcon(Icon::create('file-pdf-o'))
    ->withAttributes(['id' => "item-stock-{$item->id}"])

!!}

{!!

Button::withValue('Movimientos')
    ->asLinkTo(route("items.edit", $item->id))
    ->withIcon(Icon::create('file-pdf-o'))
    ->withAttributes(['id' => "item-movements-{$item->id}"])

!!}

@include('partials.buttons.edit-delete',['resource' => 'items', 'id' => $item->id])
