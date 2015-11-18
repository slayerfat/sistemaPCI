@if ($petition->comments !== 'Sin comentarios.' and !is_null($petition->comments))
    <p style="background-color: #f0f0f0; padding: 1em; margin: 0.3em 0;">
        {{ $petition->comments }}
    </p>
@endif
