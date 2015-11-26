@foreach ($petitions as $petition)
    <div
        class="form-group petition-table"
        data-petition-id="{{ $petition->id }}">
        <div class="control-label col-sm-2">
            <a class="btn btn-default petition-table-show-button">Ocultar
                Tabla</a>
        </div>
        <div class="col-sm-10">
            @include('notes.partials.form-items')
        </div>
    </div>
@endforeach
