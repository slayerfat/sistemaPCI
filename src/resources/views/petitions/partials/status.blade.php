<?php

if (is_null($petition->status)) {
    $status = 'null';
} elseif ($petition->status) {
    $status = 'true';
} else {
    $status = 'false';
}

?>

<meta name="csrf-token" content="{{ csrf_token() }}">

<h3 id="petition-status"
    data-route="{{ route('api.petitions.status', $petition->id) }}"
    data-status="{{ $status }}">
</h3>

@section('js-buttons')
    <script type="text/javascript">
        $(function () {
            var $statusElement = $('#petition-status');
            var url = $statusElement.data('route');

            var status = {

                status: $statusElement.data('status'),

                html: {
                    green: 'Estado: ' + '<span class="green">Aprobado ' +
                    '<i class="fa fa-check-circle"></i>' +
                    '</span>',

                    red: 'Estado: ' + '<span class="red">No Aprobado ' +
                    '<i class="fa fa-times-circle"></i>' +
                    '</span>',

                    yellow: 'Estado: ' + '<span class="yellow">Por aprobar ' +
                    '<i class="fa fa-exclamation-circle"></i> ' +
                    '<a href="' + url + '" id="petition-true">' +
                    '<button class="btn btn-success">' +
                    '<i class="fa fa-check-circle"></i> Aprobar ' +
                    '</button>' +
                    '</a> ' +
                    '<a href="' + url + '" id="petition-false">' +
                    '<button class="btn btn-danger">' +
                    '<i class="fa fa-times-circle"></i> Rechazar ' +
                    '</button>' +
                    '</a>' +
                    '</span>'
                },

                start: function () {
                    if (this.status == null) {
                        return $statusElement.append(this.html.yellow);
                    } else if (this.status) {
                        return $statusElement.append(this.html.green);
                    }

                    return $statusElement.append(this.html.red);
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

            status.start();

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
