<?php

if (is_null($note->status)) {
    $status = 'null';
} elseif ($note->status) {
    $status = 'true';
} else {
    $status = 'false';
}

?>

<meta name="csrf-token" content="{{ csrf_token() }}">

<h3 id="note-status"
    data-route="{{ route('api.notes.status', $note->id) }}"
    data-note-type-id="{{ $note->type->id }}"
    data-admin="{{ auth()->user()->isAdmin() }}"
    data-status="{{ $status }}">
</h3>

<div class="message-float alert" style="display:none;">
    <p></p>
</div>

<div class="modal fade" id="item-depot-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                <h4 class="modal-title">Asignación de Item para Almacén</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post" role="form"
                      id="item-depot-selection-form">
                    @foreach($note->items as $item)
                        <div class="form-group">
                            <label
                                for="item-depot-selection">{{ $item->desc }}</label>
                            <select name="depot" data-item="{{ $item->id }}"
                                    id="item-depot-selection"
                                    class="form-control">
                                @foreach($depots as $depot)
                                    <option value="{{ $depot->id }}">
                                        Almacén #{{ $depot->number }},
                                        Anaquel #{{ $depot->rack }},
                                        Alacena #{{ $depot->shelf }},
                                        Contiene {{ $depot->stocks->count() }}
                                        Items.
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger"
                        data-dismiss="modal">
                    Cancelar
                </button>
                <button type="button" class="btn btn-primary"
                        id="item-depot-selection-submit">
                    Completar Nota
                </button>
            </div>
        </div>
    </div>
</div>

@section('js-buttons')
    <script type="text/javascript">
        // necesitamos configurar ajax primero.
        var ajaxSetup = new Forms.AjaxSetup('{{ csrf_token() }}');
        ajaxSetup.setLaravelToken();

        var toggle = new Petition.MovementTypeToggle(
            $('#note-status').data('note-type-id'),
            '{{ route('api.petitions.movementTypes') }}'
        );

        $(function () {
            var $statusElement = $('#note-status');
            var url = $statusElement.data('route');
            var spinner = new Forms.LargeAjaxSpinner($('body'));
            var status = {
                previousStatus: '',

                status: $statusElement.data('status'),

                $msg: $('.message-float'),

                isAdmin: $statusElement.data('admin'),

                // contiene el html necesario para los botones.
                // considerar mover esto a un template.
                html: {
                    green: '<span id="green">' +
                    '<span class="green">Entregado ' +
                    '<i class="fa fa-check-circle"></i>' +
                    '</span>' +
                    '</span>',

                    red: '<span id="red">' +
                    '<span class="red">Rechazado ' +
                    '<i class="fa fa-times-circle"></i>' +
                    '</span>' +
                    '</span>',

                    nonAdminYellow: '<span id="yellow">' +
                    '<span class="yellow">Por entregar ' +
                    '<i class="fa fa-exclamation-circle"></i> ' +
                    '</span>' +
                    '</span>',

                    yellow: '<span id="yellow">' +
                    '<span class="yellow">Por entregar ' +
                    '<i class="fa fa-exclamation-circle"></i> ' +
                    '<a href="' + url + '" id="note-true">' +
                    '<button class="btn btn-success">' +
                    '<i class="fa fa-check-circle"></i> Entregado ' +
                    '</button>' +
                    '</a> ' +
                    '<a href="' + url + '" id="note-false">' +
                    '<button class="btn btn-danger">' +
                    '<i class="fa fa-times-circle"></i> Rechazar ' +
                    '</button>' +
                    '</a>' +
                    '</span>' +
                    '</span>'
                },

                /**
                 * necesitamos determinar el estatus de la nota
                 * para saber cual html de los disponibles debemos añadir.
                 * @returns {*}
                 */
                start: function () {
                    // si el estatus es nulo, entonces por aprobar
                    if (this.status == null) {
                        this.previousStatus = null;
                        // como el usuario puede ser o no administrador
                        // debemos saberlo para ver si incluimos
                        // o no los botones para aprobar/rechazar.
                        if (this.isAdmin) {
                            return $statusElement.append(this.html.yellow);
                        }

                        return $statusElement.append(this.html.nonAdminYellow);
                    } else if (this.status) {
                        return $statusElement.append(this.html.green);
                    }

                    // si el estatus no es nulo o verdadero entonces
                    // es falso y se muestra el estado rojo/no aprobado.
                    return $statusElement.append(this.html.red);
                },

                /**
                 * Cuando el usuario le da click a aprobar o rechazar, enviamos
                 * una peticion ajax al servidor y cambiamos la vista acordemente.
                 * @param string url
                 * @param bool status
                 */
                change: function (url, status, additionalData) {
                    var self = this;
                    this.previousStatus = this.status;
                    this.status = status;

                    // mandamos el texto 'null' porque llega al servidor como ''
                    data = status == null ? 'null' : status;

                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            status: data,
                            data: additionalData
                        },
                        beforeSend: function () {
                            spinner.showLargeSpinner();

                        },
                        complete: function () {
                            spinner.removeLargeSpinner();
                        }
                    }).success(function (data) {
                        var element;
                        var next;
                        var previous;

                        if (data.status === false) {
                            var msg = 'Error Desconocido en el servidor.';
                            if (data.message) {
                                msg = data.message;
                            }
                            return self.createMessage(msg, 'alert alert-danger');
                        }

                        // debemos determinar cual es el elemento que
                        // estaba activo cuando se hizo la peticion.
                        if (self.status == self.previousStatus) {
                            self.createMessage(
                                'Error, no se pudo cambiar estatus, intente nuevamente.',
                                'alert alert-warning'
                            );
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
                            'Cambios realizados correctamente. ',
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

            // aqui empieza.
            status.start();

            $('#note-true').click(function (evt) {
                evt.preventDefault();

                // si es ingreso se muestra el formulario para poner el item en algun almacen
                if (toggle.isModelIngress()) {
                    return $('#item-depot-modal').modal('show');
                }

                // el api necesita un array con la data del objeto creado aqui
                status.change(url, true, [{
                    item: null,
                    depot: null
                }]);
            });

            $('#note-false').click(function (evt) {
                evt.preventDefault();

                status.change($(this).prop('href'), false);
            });

            $('#item-depot-selection-submit').click(function (evt) {
                evt.preventDefault();
                var values = [];

                $('#item-depot-selection-form').find(':input').each(function () {
                    values.push({
                        item: $(this).data('item'),
                        depot: $(this).val()
                    });
                });

                $('#item-depot-modal').modal('hide');
                status.change(url, true, values);
            });
        })
    </script>
@stop
