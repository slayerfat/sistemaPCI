<section>
    @if (!$petitions->isEmpty())
        @foreach ($petitions as $petition)
            <p>
                {!! link_to_route('users.show', $petition->user->name, $petition->user->name) !!}
                ha creado el {{ trans('models.petitions.singular') }}
                {!! link_to_route('petitions.show', '#'.$petition->id, $petition->id) !!}
                ,
                que
                posee {{ $petition->items->count() }} {{ trans('models.items.plural') }}
                {{ $petition->created_at->diffForHumans() }}
            </p>
        @endforeach
    @else
        <h2>
            No hay nuevos {{ trans('models.petitions.plural') }} que mostrar.
        </h2>
    @endif

    <hr>

    @if (!$notes->isEmpty())
        @foreach ($notes as $note)
            <p>
                {!! link_to_route('users.show', $note->user->name, $note->user->name) !!}
                ha creado la {{ trans('models.notes.singular') }}
                {!! link_to_route('notes.show', '#'.$note->id, $note->id) !!},
                asociado al {{ trans('models.petitions.singular') }}
                {!! link_to_route('petitions.show', '#'.$note->petition->id, $note->petition->id) !!}
                ,
                que
                posee {{ $note->items->count() }} {{ trans('models.items.plural') }}
                {{ $note->created_at->diffForHumans() }}
            </p>
        @endforeach
    @else
        <h2>
            No hay nuevas {{ trans('models.notes.plural') }} que mostrar.
        </h2>
    @endif
</section>
