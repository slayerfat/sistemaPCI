<?php

// si el estatus no es nulo entonces ha sido aprobado/rechazado
$buttons = '';

// debemos chequear el estado para determinar
// que tipo de colores debemos botar, con o sin botones.
if (is_null($petition->status)) {
    $status  = '<span class="yellow">';
    $icon    = ' <i class="fa fa-exclamation-circle"></i>';
    $buttons = '<a href="">
                    <button class="btn btn-success">
                        <i class="fa fa-check-circle"></i> Aprobar
                    </button>
                </a>
                <a href="">
                    <button class="btn btn-danger">
                        <i class="fa fa-times-circle"></i> Rechazar
                    </button>
                </a>';
} elseif($petition->status) {
    $status = '<span class="green">';
    $icon   = ' <i class="fa fa-check-circle"></i>';
} else {
    $status = '<span class="red">';
    $icon   = ' <i class="fa fa-times-circle"></i>';
}

$status .= $petition->formattedStatus . $icon . $buttons .'</span>'

?>

<h3>
    Estado: {!! $status !!}
</h3>
