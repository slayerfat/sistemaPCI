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
                }
            }).success(function (data) {
                if (data.status == true) {
                    button.success();
                    button.sent = true;
                }
            }).fail(function () {
                button.fail();
            })
        })
    </script>
@stop
