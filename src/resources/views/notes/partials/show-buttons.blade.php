@if(auth()->user()->isAdmin())
    <span style="float: right">
        {!!

        Button::withValue('Generar PDF')
            ->asLinkTo(route('api.notes.pdf', $note->id))
            ->withAttributes(['id' => 'note-pdf',])
            ->withIcon(Icon::create('file-pdf-o'))

        !!}
    </span>
@endif
