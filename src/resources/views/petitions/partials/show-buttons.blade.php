@if(auth()->user()->isAdmin())
    <span style="float: right">
        @if (is_null($petition->status))
            {!!

            Button::withValue('Solicitar Aprobación')
                ->asLinkTo('#')
                ->withAttributes([
                    'id'        => 'petition-approval-request',
                    'data-url'  => route('api.petitions.approvalRequest', $petition->id),
                ])->withIcon(Icon::create('exclamation-circle'))

            !!}
            @include(
                'partials.buttons.edit-delete',
                ['resource' => 'petitions', 'id' => $petition->id]
            )
        @endif
    </span>
@endif

@section('js-show-buttons')
    <script type="text/javascript">
        var $element = $('#petition-approval-request');
        var button = new Forms.ButtonSpinner($element);
        var message = new Forms.Message;
        button.sent = false;

        $element.click(function (evt) {
            evt.preventDefault();

            // si la peticion ha sido enviada, se regresa prematuramente.
            if (button.sent) return;

            $.ajax({
                url: $element.data('url'),
                method: 'POST',
                dataType: 'json',
                beforeSend: function () {
                    button.before('fa-exclamation-circle');
                },
                complete: function () {
                    button.complete();
                    button.sent = true;
                }
            }).success(function (data) {
                if (data.status == true) {
                    button.success();

                    return message.createMessage(
                        'Solicitud realizada correctamente.',
                        'alert alert-success'
                    );
                }

                button.fail();
                var msg = 'Error inesperado en el servidor.';

                if (data.message) {
                    msg = data.message;
                }

                return message.createMessage(msg, 'alert alert-warning');
            }).fail(function () {
                button.fail();

                return message.createMessage(
                    'Error!',
                    'alert alert-danger'
                );
            });
        })
    </script>
@stop
