<meta name="form-data"
      data-petition-items-url="{{ route('api.petitions.items') }}"
      data-model-movement-type-url="{{ route('api.petitions.movementTypes') }}"
      data-petition-items-id="{{ $petition->id }}"
      data-editing="{{ $petition->id ? "true" : "false" }}">
{!!

ControlGroup::generate(
    BSForm::label('petition_type_id', 'Tipo de solicitud'),
    BSForm::select('petition_type_id', $types),
    BSForm::help('&nbsp;'),
    2
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('itemList', 'Items'),
    BSForm::select('itemList'),
    BSForm::help('Aqui puede seleccionar cuales items desea solicitar'),
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

@section('js')
    <script>
        // elementos varios de HTML
        var $formData = $('meta[name="form-data"]');
        var url = $formData.data('model-movement-type-url');
        var $petitionTypeSelect = $('#petition_type_id');

        // las clases varias a iniciar
        var commentToggle = new Forms.ToggleComments($('#comments'));
        var toggle = new Petition.MovementTypeToggle($petitionTypeSelect.val(), url);
        var stockTypes = new Petition.stockTypes();
        var items = new Petition.RelatedItems();
        var ajaxSetup = new Forms.AjaxSetup($('input[name="_token"]'));

        // operaciones iniciales
        toggle.selectWatcher($petitionTypeSelect);
        ajaxSetup.setLaravelToken();

        /**
         * la informacion html que es usada para generar
         * los elementos internos del select.
         * @param data
         * @returns {string}
         */
        function formatRepo(data) {
            // Cambiamos el texto que se ve mientras se hace la busqueda.
            if (data.loading) return data.text;

            // poderosisimo copypasta.
            var markup = '<div class="clearfix">' +
                '<div class="col-xs-12">' +
                '<div class="clearfix">' +
                '<div class="col-sm-6">' + data.desc + '</div>' +
                '<div class="col-sm-3"><i class="fa fa-industry"></i> ' + data.maker.desc + '</div>' +
                '<div class="col-sm-3"><i class="fa fa-random"></i> ' + data.sub_category.desc + '</div>' +
                '</div>';

            markup += '</div></div>';

            return markup;
        }

        var $itemList = $("#itemList");

        // aqui empieza la mamarrachada principal
        $itemList.select2({
            language: 'es',
            placeholder: "Indique su busqueda",
            // hacemos una peticion ajax
            ajax: {
                // por alguna razon el url no estaba siendo formateado
                // correctamente, esta es una solucion temporal y mamarracha.
                url: function (params) {
                    return "/api/items/search/" + params.term;
                },
                dataType: 'json',
                delay: 250,

                data: function (params) {
                    return {
                        term: params.term, // el termino a buscar
                        page: params.page
                    };
                },

                /**
                 * regresa un objeto con los resultados para ser procesados.
                 * @param data
                 * @param params
                 * @returns {results: *, pagination: {more: boolean}}
                 */
                processResults: function (data, params) {
                    // page es un atributo que maneja select2.
                    // basicamente determina la pagina
                    // en la que esta para la paginacion.
                    params.page = params.page || 1;

                    // esto basicamente permite volver a seleccionar el mismo elemento
                    // otra vez de la lista (necesario por el cambio alterno
                    // de tipo de movimiento/pedido/nota)
                    $itemList.val(null);

                    return {
                        results: data.data,
                        pagination: {
                            more: (params.page * 10) < data.total
                        }
                    };
                },
                cache: true
            },

            // magia.
            escapeMarkup: function (markup) {
                return markup;
            },

            minimumInputLength: 1,
            templateResult: formatRepo
        });

        // mamarrachada de segundo orden
        $itemList.on("select2:select", function (e) {
            items.appendItem(e, stockTypes, toggle);

            $('.itemBag-remove-item').click(function () {
                var $item = $(this).closest('.itemBag-item');
                var id = $item.data('id');
                $item.toggle(function () {
                    items.removeSelected(id);
                    $item.remove()
                });
            });
        });
    </script>

    <script>
        $(function () {
            var $formData = $('meta[name="form-data"]');

            // si no se esta editando, entonces no ocurre nada aca.
            if (!$formData.data('editing')) return;

            var html = '<div class="col-xs-push-4 col-xs-4 text-center">' +
                '<i class="fa fa-spinner fa-spin fa-5x"></i>' +
                '</div>';

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
                        $('#itemBag').empty();
                        Object.keys(data).forEach(function (key) {
                            var item = {
                                params: {
                                    data: null
                                }
                            };

                            item.params.data = data[key];
                            items.appendItem(item);
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

            $('#itemBag').fadeOut(250, function () {
                $('#itemBag').append(html).fadeIn(250);
                startAjax();
            });
        })
    </script>
@stop
