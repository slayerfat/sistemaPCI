<?php

// si el estatus no es nulo entonces ha sido aprobado/rechazado
$buttons = '';

$route = route('api.petitions.status', $petition->id);

// debemos chequear el estado para determinar
// que tipo de colores debemos botar, con o sin botones.
if (is_null($petition->status)) {
    $status  = '<span class="yellow">';
    $icon    = ' <i class="fa fa-exclamation-circle"></i>';
    $buttons = '<a  href="' . $route . '" id="petition-true">
                    <button class="btn btn-success">
                        <i class="fa fa-check-circle"></i> Aprobar
                    </button>
                </a>
                <a href="' . $route . '" id="petition-false">
                    <button class="btn btn-danger">
                        <i class="fa fa-times-circle"></i> Rechazar
                    </button>
                </a>';
} elseif ($petition->status) {
    $status = '<span class="green">';
    $icon   = ' <i class="fa fa-check-circle"></i>';
} else {
    $status = '<span class="red">';
    $icon   = ' <i class="fa fa-times-circle"></i>';
}

$status .= $petition->formattedStatus . $icon . $buttons . '</span>'

?>

<meta name="csrf-token" content="{{ csrf_token() }}">

<h3 id="petition-status"
    data-status="{{ is_null($petition->status) ? 'null' : 'bool'}}">
    Estado: {!! $status !!}
</h3>

@section('js-buttons')
    <script type="text/javascript">
        $(function () {
            var status = {

                status: null,

                buttons: {
                    text: 'Estado: ',
                    green: this.text + '<span class="green">Aprobado <i class="fa fa-check-circle"></i></span>',
                    red: this.text + '<span class="red">No Aprobado <i class="fa fa-times-circle"></i></span>',
                    yellow: ''
                },

                change: function (url, status) {
                    this.status = status;

                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        data: {status: status}
                    }).done(function () {
                        console.log("success");
                    }).fail(function () {
                        console.log("error");
                    });
                }
            };

            var $statusElement = $('#petition-status');

            if ($statusElement.data('status') == null) {
                status.buttons.yellow = $statusElement.html();
            }

            console.log(status);

            // http://laravel.com/docs/master/routing#csrf-x-csrf-token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#petition-true').click(function (evt) {
                evt.preventDefault();

                status.change($(this).prop('href'), true);
            });

            $('#petition-false').click(function (evt) {
                evt.preventDefault();

                status.change($(this).prop('href'), false);
            });
        })
    </script>
@stop
