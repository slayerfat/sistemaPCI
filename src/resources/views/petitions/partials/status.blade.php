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

<div class="message-float alert" style="display:none;">
    <p></p>
</div>

@section('js-buttons')
    <script type="text/javascript">
        $(function () {
            var $statusElement = $('#petition-status');
            var url = $statusElement.data('route');

            var status = {
                previousStatus: '',

                status: $statusElement.data('status'),

                $msg: $('.message-float'),

                // contiene el html necesario para los botones.
                // considerar mover esto a un template.
                html: {
                    green: '<span id="green">Estado: ' +
                    '<span class="green">Aprobado ' +
                    '<i class="fa fa-check-circle"></i>' +
                    '</span>' +
                    '</span>',

                    red: '<span id="red">Estado: ' +
                    '<span class="red">No Aprobado ' +
                    '<i class="fa fa-times-circle"></i>' +
                    '</span>' +
                    '</span>',

                    yellow: '<span id="yellow">Estado: ' +
                    '<span class="yellow">Por aprobar ' +
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
                    '</span>' +
                    '</span>'
                },

                /**
                 * necesitamos determinar el estatus del pedido
                 * para saber cual html de los disponibles debemos añadir.
                 * @returns {*}
                 */
                start: function () {
                    if (this.status == null) {
                        this.previousStatus = null;
                        return $statusElement.append(this.html.yellow);
                    } else if (this.status) {
                        return $statusElement.append(this.html.green);
                    }

                    return $statusElement.append(this.html.red);
                },

                /**
                 * Cuando el usuario le da click a aprobar o rechazar, enviamos
                 * una peticion ajax al servidor y cambiamos la vista acordemente.
                 * @param string url
                 * @param bool status
                 */
                change: function (url, status) {
                    var self = this;
                    this.previousStatus = this.status;
                    this.status = status;

                    // mandamos el texto 'null' porque llega al servidor como ''
                    data = status == null ? 'null' : status;

                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        data: {status: data}
                    }).done(function (data) {
                        var element;
                        var next;
                        var previous;

                        // debemos determinar cual es el elemento que
                        // estaba activo cuando se hizo la peticion.
                        if (self.status == self.previousStatus) {
                            return console.log('status iguales');
                        } else if (self.previousStatus == null) {
                            previous = 'yellow';
                        } else {
                            previous = self.previousStatus ? 'green' : 'red';
                        }

                        // luego debemos determinar cual es el
                        // elemento que debemos activar.
                        if (status == null && data.status) {
                            element = self.html.yellow;
                            next = 'yellow';
                        } else {
                            element = self.status ? self.html.green : self.html.red;
                            next = self.status ? 'green' : 'red';
                        }

                        // esperamos 250 milsegs, luego limpiamos
                        // el contenido html y lo cambiamos por el elemento.
                        $statusElement.animate({opacity: 0}, 250, 'linear', function () {
                            var $next = $('#' + next);

                            // si el elemento no existe se introduce,
                            // de lo contrario se ignora
                            if (!$next.length) {
                                $statusElement.append(element);
                            }

                            $next.removeClass('hidden');
                            $('#' + previous).addClass('hidden');
                        }).animate({opacity: 1}, 250, 'linear');

                        // creamos un mensaje segun este metodo.
                        self.createMessage(
                                'Cambios realizados correctamente. ' +
                                '<a href="#" id="message-undo">deshacer</a>',
                                'alert alert-success'
                        );
                    }).fail(function () {
                        self.createMessage(
                                'Error Desconocido en el servidor.',
                                'alert alert-warning'
                        );
                    });
                },

                /**
                 * Creamos un mensaje que flotara en
                 * la vista con la informacion suministrada.
                 * @param string msg el mensaje para el usuario
                 * @param string classes las clases para el css
                 */
                createMessage: function (msg, classes) {
                    var self = this;

                    this.$msg.removeClass('alert alert-danger alert-success')
                            .addClass(classes)
                            .show()
                            .children()
                            .html(msg);

                    this.$msg.children().children().click(function () {
                        status.change(url, self.previousStatus);
                        self.toggleMessage();
                    });

                    setTimeout(this.toggleMessage, 10000);
                },

                /**
                 * cambia el estado del mensaje ya creado.
                 */
                toggleMessage: function () {
                    return status.$msg.fadeToggle(1000, function () {
                        $(this).children().empty();
                    });
                }
            };

            // aqui empieza el mamarrachismo.
            status.start();

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
