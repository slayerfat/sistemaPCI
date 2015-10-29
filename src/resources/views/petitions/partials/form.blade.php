<meta name="form-data"
      data-petition-items-url="{{ route('api.petitions.items') }}"
      data-petition-movement-type-url="{{ route('api.petitions.movementTypes') }}"
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
        /**
         * Como los comentarios llegan sucios, debemos limpiarlos
         * cuando estamos creando una nueva peticion.
         */
        $(function () {
            var $comments = $('#comments');
            var val = $comments.val();

            if ($('meta[name="form-data"]').data('editing')) return;

            if (val.length > 1) {
                $comments.val('').prop('placeholder', 'Introduzca un comentario.');
            }
        });
    </script>
    <script>
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

        // necesitamos los tipos de stock para generar el select
        $(function () {
            $.ajax({
                url: '/api/tipos-cantidad',
                dataType: 'json',
                success: function (data) {
                    stockTypes.types = data;
                }
            });
        });

        var stockTypes = {
            types: {}
        };

        var items = {
            data: {
                desc: '',
                stock_type_id: null
            },

            selected: [],

            stock: {
                plain: '',
                formatted: ''
            },

            setItem: function (data) {
                this.data = data;
                this.grabItemStock(this.data);
            },

            grabItemStock: function (item) {
                var self = this;

                $.ajax({
                    url: '/api/items/stock/' + item.id,
                    dataType: 'json',
                    async: false,
                    success: function (data) {
                        self.setStock(data);
                    }
                });
            },

            addSelected: function (id) {
                this.selected.push(parseInt(id));
            },

            removeSelected: function (id) {
                this.selected.splice(this.selected.indexOf(parseInt(id)), 1);
            },

            setStock: function (stock) {
                this.stock = stock;
            },

            alreadySelected: function () {
                var selected = false;

                this.selected.forEach(function (key) {
                    if (key == this.data.id) selected = true;
                }.bind(this));

                return selected;
            },

            appendItem: function (e) {
                // iniciamos el objeto
                items.setItem(e.params.data);

                if (items.alreadySelected()) {
                    return;
                }

                var itemBag = $('#itemBag');

                // chequeamos que el stock no sea 0
                if (items.stock.plain < 1) {
                    var $error = $('<label for="itemBag" class="control-label col-sm-8">' +
                        items.data.desc + ' no se encuentra en existencia.' +
                        '</label>');

                    itemBag.append($error);

                    // espera 10 segundo y activa la animacion
                    $error.animate({opacity: 1}, 10000, 'linear', function () {
                        $error.animate({opacity: 0}, 2000, 'linear', function () {
                            $error.remove();
                        });
                    });

                    return;
                }

                // como esta mamarrachada es muy grande, la
                // segmentamos para que pueda ser mas facil de digerir
                var itemInput = '<div class="itemBag-item" data-id="' + items.data.id + '">'
                    + '<label for="itemBag" class="control-label col-sm-7">'
                    + items.data.desc
                    + '</label>'
                    + '<div class="col-sm-2">' +
                    '<input class="form-control" name="item-id-' + items.data.id + '" type="number" min="1" value="' + items.stock.plain + '" max="' + items.stock.plain + '">' +
                    '<span class="help-block">' + items.stock.formatted + ' en total.' + '</span>' +
                    '</div>';

                var options = '';

                // generamos las opciones que van dentro del select
                Object.keys(stockTypes.types).forEach(function (key) {
                    stockTypes.types[key].id == items.data.stock_type_id
                        ? options += '<option value="' + stockTypes.types[key].id + '" selected="selected">' + stockTypes.types[key].desc + '</option>'
                        : options += '<option value="' + stockTypes.types[key].id + '">' + stockTypes.types[key].desc + '</option>';
                });

                // este select contiene los tipos de cantidad
                var select = '<div class="col-sm-3">  <div class="input-group">' +
                    '<select class="form-control" name="stock-type-id-' +
                    items.data.id + '">' + options + '</select>' +
                    '<span class="input-group-addon itemBag-remove-item" ' +
                    'data-id="' + items.data.id + '">' +
                    '<i class="fa fa-times"></i></span>' +
                    '</div>' +
                    '</div>';

                itemBag.append(itemInput + select);

                items.addSelected(items.data.id);
            }
        };

        // mamarrachada de segundo orden
        $itemList.on("select2:select", function (e) {
            items.appendItem(e);

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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                }
            });

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

    {{--determina tipo de movimiento--}}
    <script>
        var $formData = $('meta[name="form-data"]');
        var toggle = new Petition.MovementTypeToggle;
        var url = $formData.data('url');

        $('#petition_type_id').change(function () {
            toggle.id = $(this).val();
            toggle.url = 'ayy';
            toggle.test();
            toggle.getModel();
        });
    </script>
@stop
