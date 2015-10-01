<div>
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
</div>
