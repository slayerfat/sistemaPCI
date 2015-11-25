{!!

Button::withValue('Reporte General')
    ->asLinkTo(route("api.items.pdf.single", $item->id))
    ->withIcon(Icon::create('file-pdf-o'))
    ->withAttributes(['id' => "item-report-{$item->id}"])

!!}

{!!

Button::withValue('Stock')
    ->asLinkTo(route("api.items.pdf.stock", $item->id))
    ->withIcon(Icon::create('file-pdf-o'))
    ->withAttributes(['id' => "item-stock-{$item->id}"])

!!}

{!!

Button::withValue('Movimientos')
    ->asLinkTo(route("api.items.pdf.movements", $item->id))
    ->withIcon(Icon::create('file-pdf-o'))
    ->withAttributes(['id' => "item-movements-{$item->id}"])

!!}

@include('partials.buttons.edit-delete',['resource' => 'items', 'id' => $item->id])
