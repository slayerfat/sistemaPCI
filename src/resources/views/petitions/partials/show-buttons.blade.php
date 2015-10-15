<span style="float: right">
    @if (is_null($petition->status))
        {!!

        Button::withValue('Solicitar Aprobación')
            ->withAttributes([
                'id' => 'petition-approval-request',
                'data-sent' => 'false',
                'data-url' => route('api.petitions.approvalRequest', $petition->id),
            ])->withIcon(Icon::create('exclamation-circle'))

        !!}
        @include(
            'partials.buttons.edit-delete',
            ['resource' => 'petitions', 'id' => $petition->id]
        )
    @endif
</span>

@section('js-show-buttons')
    <script type="text/javascript">
        $('#petition-approval-request').click(function () {
            var $sent = $(this);

            // si la peticion ha sido enviada, se regresa prematuramente.
            if ($sent.data('sent')) return;

            $.ajax({
                url: $sent.data('url'),
                method: 'POST',
                dataType: 'json',
                beforeSend: function() {
                    $('#petition-approval-request')
                            .removeClass('btn-default')
                            .addClass('btn-warning')
                            .find('span').removeClass('fa-exclamation-circle')
                            .addClass('fa-spinner fa-spin');
                },
                complete: function() {
                    $('#petition-approval-request')
                            .removeClass('btn-warning')
                            .find('span').removeClass('fa-spinner fa-spin');
                }
            }).success(function (data) {
                if (data.status == true) {
                    $('#petition-approval-request')
                            .removeClass('btn-default')
                            .addClass('btn-success')
                            .find('span')
                            .addClass('fa-check-circle');

                    $sent.data('sent', true);
                }
            }).fail(function () {
                $('#petition-approval-request')
                        .removeClass('btn-default')
                        .addClass('btn-danger')
                        .find('span')
                        .removeClass('*')
                        .addClass('fa-times-circle');
            })
        })
    </script>
@stop
