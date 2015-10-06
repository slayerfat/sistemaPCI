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
         * la informacion html que es usada para generar
         * los elementos internos del select.
         * @param data
         * @returns {string}
         */
        function formatRepo(data) {
            // Cambiamos el texto que se ve mientras se hace la busqueda.
            // data.text = 'Buscando...';
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


        items = {
            data: {
                desc: ''
            },

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

            setStock: function (stock) {
                this.stock = stock;
            }
        };

        $itemList.on("select2:select", function (e) {
            items.setItem(e.params.data);

            var itemBag = $('#itemBag');

            if (items.stock.plain < 1) {
                var $error = $('<label for="itemBag" class="control-label col-sm-8">' +
                items.data.desc + ' no se encuentra en existencia.' +
                '</label>');

                itemBag.append($error);

                $error.animate({opacity: 1}, 10000, 'linear', function () {
                    $error.animate({opacity: 0}, 2000, 'linear', function () {
                        $error.remove();
                    });
                });

                return;
            }

            itemBag.append(
                '<label for="itemBag" class="control-label col-sm-8">'
                + items.data.desc
                + '</label>'
                + '<div class="col-sm-4">' +
                '<input class="form-control" name="item-id-' + items.data.id + '" type="number" min="1" value="' + items.stock.plain + '" max="' + items.stock.plain + '">' +
                '<span class="help-block">' + items.stock.formatted + ' en total.' + '</span>' +
                '</div>'
            );
        });
    </script>
@stop
