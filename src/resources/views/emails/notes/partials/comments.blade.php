@if ($note->comments !== 'Sin comentarios.' and !is_null($note->comments))
    <p style="background-color: #f0f0f0; padding: 1em; margin: 0.3em 0;">
        {{ $note->comments }}
    </p>
@endif
