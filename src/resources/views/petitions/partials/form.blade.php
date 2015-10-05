{!!

ControlGroup::generate(
    BSForm::label('itemList', 'Items'),
    BSForm::select('itemList'),
    BSForm::help('Aqui puede seleccionar cuales items desea solicitar'),
    2
)

!!}

{!! Button::primary($btnMsg)->block()->submit() !!}

@section('js')
    <link
        href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css"
        rel="stylesheet"/>
    <script
        src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
    <script>
        /**
         * FIXME inclur dependencias
         * la informacion html que es usada para generar
         * los elementos internos del select.
         * @param data
         * @returns {string}
         */
        function formatRepo(data) {
            // Cambiamos el texto que se ve mientras se hace la busqueda.
            data.text = 'Buscando...';
            if (data.loading) return data.text;

            console.log('ITS HAPPENING: ' + JSON.stringify(data));

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

        // aqui empieza la mamarrachada principal
        $("#itemList").select2({
            // hacemos una peticion ajax
            ajax: {
                url: function (params) {
                    console.log('url params: ' + JSON.stringify(params));
                    return "/api/items/search/" + params.term;
                },
                dataType: 'json',
                delay: 250,

                data: function (params) {
                    return {
                        term: params.term, // search term
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
                    console.log('processResults data: ' + JSON.stringify(data));
                    console.log('processResults params: ' + JSON.stringify(params));

                    // a espera de determinar.
                    params.page = params.page || 1;

                    return {
                        results: data.data,
                        pagination: {
                            more: (params.page * 30) < data.total_count
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
    </script>
@stop
