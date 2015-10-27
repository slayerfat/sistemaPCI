<section class="item-stock">
    <h2>{{$title or null}}</h2>

    <?php $reserved = $item->percentageReserved(); ?>
    <?php $stock = abs($reserved - 100); ?>

    {!!

    ProgressBar::stack([
        ['success', 'value='.$stock, 'visible=Existencia %s%%'],
        ['danger', 'value='.$reserved, 'visible=Reservado %s%%'],
    ])

    !!}

    <h3>
        <small>
            {{ $item->formattedRealStock() }} En almacenes.
            {{ $item->formattedReserved() }}
            {{ $item->reserved > 1 ? 'Reservados' : 'Reservado' }}.
        </small>
    </h3>
</section>
