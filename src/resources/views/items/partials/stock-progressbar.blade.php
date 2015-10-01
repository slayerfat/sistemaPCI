<section class="item-stock">
    <h2>{{$title or null}}</h2>

    <?php
    $value = $item->percentageStock();
    $visible = ' %s%%';
    if ($item->minimum <= 1) {
        $type    = 'normal';
        $visible = 'Configure stock minimo.';
        $value   = 0;
    } elseif ($value <= 20) {
        $type = 'danger';
    } elseif ($value <= 40) {
        $type = 'warning';
    } elseif ($value <= 100) {
        $type = 'success';
    } else {
        $type    = 'success';
        $value   = 100;
        $visible = 'Por encima del %s%%!';
    }
    ?>
    {!!ProgressBar::$type($value)->visible($visible)->animated()!!}

    <h3>
        <small>
            {{$item->stock}}
            <?php //TODO: a espera de tipo de unidades ?>
            en existencia.

            @if(auth()->user()->isAdmin())
                {{$item->minimum <= 1 ?
                    'Stock minimo no asignado.' : "La existencia minima es $item->minimum."}}
            @endif
        </small>
    </h3>
</section>
