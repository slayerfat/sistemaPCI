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
            var sent = $(this).data('sent');
            var url = $(this).data('url');
            if (sent) return;

            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json'
            }).success(function (data) {
                if (data.status == true) {
                    $('#petition-approval-request')
                            .removeClass('btn-default')
                            .addClass('btn-success');
                }
            }).fail()
        })
    </script>
@stop
