<section class="item-stock">
    <h2>{{$title or null}}</h2>

    <?php $reserved = $item->percentageReserved(); ?>
    <?php $stock = abs($reserved - 100); ?>
    <?php $stock = $stock >= 100 ? 0 : $stock ?>

    @if($reserved == 0)

    {!!

    ProgressBar::success(100)->visible("Reservado $reserved%% de la existencia.")

    !!}

    @elseif($stock == 0)

    {!!

    ProgressBar::danger(100)->visible("Advertencia reservado $reserved%% de la existencia.")

    !!}

    @else

    {!!

    ProgressBar::stack([
        ['success', 'value='.$stock, 'visible=Existencia %s%%'],
        ['danger', 'value='.$reserved, 'visible=Reservado %s%%'],
    ])

    !!}

    @endif

    <h3>
        <small>
            {{ $item->formattedRealStock() }} En almacenes.
            {{ $item->formattedReserved() }}
            {{ $item->reserved !== 1 ? 'Reservados' : 'Reservado' }}.
        </small>
    </h3>
</section>
