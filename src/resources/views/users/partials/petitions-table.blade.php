<h1>Últimos Pedidos</h1>
@foreach($user->petitions()->latest() as $petition)
    <section class="user-petitions">
        <h1>
            <a href="{{ route('petitions.show', $petition->id) }}">
                Nº {{ $petition->id }} | {{ $petition->formattedStatus }}
            </a>
        </h1>
        @include('petitions.partials.items')
    </section>
@endforeach
