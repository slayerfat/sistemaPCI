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

@section('js')
    <script>
        // necesitamos configurar ajax primero.
        var ajaxSetup = new Forms.AjaxSetup($('input[name="_token"]'));
        ajaxSetup.setLaravelToken();

        // elementos varios de HTML
        var $formData = $('meta[name="form-data"]');
        var url = $formData.data('model-movement-type-url');
        var $select = $('#note_type_id');

        // las clases varias a iniciar
        var commentToggle = new Forms.ToggleComments($('#comments'));
        var toggle = new Petition.MovementTypeToggle($select.val(), url);
        var stockTypes = new Petition.stockTypes();
        var items = new Petition.RelatedItems();
        var ajaxSpinner = new Forms.AjaxSpinner($('#itemBag'));

        // operaciones iniciales
        toggle.selectWatcher($select);
        ajaxSpinner.appendSpinner();

        $(function () {
            // si no se esta editando, entonces no ocurre nada aca.
            if (!$formData.data('editing')) return;

            $('#petition_id').change(function () {
                $formData.data('petition-items-id', $(this).val());
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
                            items.appendNoteItem(item, stockTypes, toggle);
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

            startAjax();
        })
    </script>
@stop
