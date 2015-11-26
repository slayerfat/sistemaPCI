@if(auth()->user()->isAdmin())
    <span style="float: right">
        {!!

        Button::withValue('Generar PDF')
            ->asLinkTo(route('api.depots.pdf.single', $depot->id))
            ->withAttributes(['id' => 'depots-pdf',])
            ->withIcon(Icon::create('file-pdf-o'))

        !!}

        @include('partials.buttons.edit-delete', [
            'resource' => 'depots', 'id' => $depot->id
        ])
    </span>
@endif
