<meta name="form-data"
      data-petition-items-url="{{ route('api.petitions.items') }}"
      data-model-movement-type-url="{{ route('api.notes.movementTypes') }}"
      data-petition-items-id="{{ $petitions->first()->id }}"
      data-editing="{{ $petitions->first()->id ? "true" : "false" }}">

{!!

ControlGroup::generate(
    BSForm::label('to_user_id', 'Dirigido a'),
    BSForm::select('to_user_id', $users),
    BSForm::help('&nbsp;'),
    2
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('note_type_id', 'Tipo de Nota'),
    BSForm::select('note_type_id', $types),
    BSForm::help('&nbsp;'),
    2
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('petition_id', 'Pedido Asociado'),
    BSForm::select('petition_id', $list),
    BSForm::help('&nbsp;'),
    2
)

!!}

<div class="form-group" id="itemBag"></div>

{!!

ControlGroup::generate(
    BSForm::label('comments', 'Comentarios'),
    BSForm::textarea('comments'),
    BSForm::help('&nbsp;'),
    2
)

!!}

{!! Button::primary($btnMsg)->block()->submit() !!}

@section('css')
    <link rel="stylesheet" href="{{elixir('css/vendor.css')}}"/>
@stop

@section('form-js')
    <script type="text/javascript" src="{!! elixir('js/datepicker.js') !!}">
    </script>

    <script>
        // necesitamos configurar ajax primero.
        var ajaxSetup = new Forms.AjaxSetup('{{ csrf_token() }}');
        ajaxSetup.setLaravelToken();

        // elementos varios de HTML
        var $formData = $('meta[name="form-data"]');
        var url = $formData.data('model-movement-type-url');
        var $select = $('#note_type_id');

        // las clases varias a iniciar
        var commentToggle = new Forms.ToggleComments($('#comments'));
        var toggle = new Petition.MovementTypeToggle($select.val(), url);
        var stockTypes = new Petition.stockTypes();
        var items = new Petition.RelatedItems('note');
        var ajaxSpinner = new Forms.AjaxSpinner($('#itemBag'));

        // operaciones iniciales
        toggle.selectWatcher($select);
        ajaxSpinner.appendSpinner();

        $(function () {
            // si no se esta editando, entonces no ocurre nada aca.
            if (!$formData.data('editing')) return;

            $('#petition_id').change(function () {
                $formData.data('petition-items-id', $(this).val());
                items.resetSelected();
                startAjax();
            });

            function startAjax() {
                $.ajax({
                    url: $formData.data('petition-items-url'),
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        id: $formData.data('petition-items-id')
                    },
                    success: function (data) {
                        var self = this;

                        ajaxSpinner.cleanSpinner();

                        Object.keys(data).forEach(function (key) {
                            var item = {
                                params: {
                                    data: null
                                }
                            };

                            item.params.data = data[key];
                            items.appendItem(item, stockTypes, toggle);
                        });

                        $('.itemBag-remove-item').click(function () {
                            self.removeItem($(this))
                        });
                    },
                    removeItem: function ($element) {
                        var $item = $element.closest('.itemBag-item');
                        var id = $item.data('id');

                        $item.toggle(function () {
                            items.removeSelected(id);
                            $item.remove()
                        });
                    }
                })
            }

            // variable de control
            var i = 0;

            /**
             * iniciamos, si no se inicia correctamente
             * en 30 segundos, emite mensaje de error
             * @returns {*}
             */
            function start() {
                i++; // control
                var status = stockTypes.isNotEmpty();

                // si el estatus es verdadero, entonces empezamos el ajax
                if (status) {
                    return startAjax();
                } else if (i == 30) {
                    i = 0;

                    // pasado 30 segundos, emitimos mensaje de error, y
                    // generamos un evento onclick en el boton.
                    return items.appendStockTypeError(
                        $('#itemBag'),
                        stockTypes,
                        toggle,
                        function (event) {
                            event.preventDefault();
                            ajaxSpinner.appendSpinner();
                            $('#itemBag').empty();
                            start();
                        }
                    );
                }

                // cada segundo intentamos ver si se puede arrancar.
                var t = setTimeout(function () {
                    start()
                }, 1000);
            }

            // arranca por primera vez.
            start();
        })
    </script>
@stop
