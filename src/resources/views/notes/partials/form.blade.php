<meta name="form-data"
      data-petition-items-url="{{ route('api.petitions.items') }}"
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

                var $itemBag = $('#itemBag');

                // chequeamos que el stock no sea 0
                if (items.stock.plain < 1) {
                    var $error = $('<label for="itemBag" class="control-label col-sm-8">' +
                        items.data.desc + ' no se encuentra en existencia.' +
                        '</label>');

                    $itemBag.append($error);

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

                $itemBag.append(itemInput + select);

                items.addSelected(items.data.id);
            }
        };
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

            $('#petition_id').change(function () {
                $formData.data('petition-items-id', $(this).val());
                startAjax();
            });

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
