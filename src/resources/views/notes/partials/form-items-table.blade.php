@foreach ($petitions as $petition)
    <div
        class="form-group petition-table"
        data-petition-id="{{ $petition->id }}">
        <div class="col-sm-10 col-sm-push-2">
            @include('notes.partials.form-items')
        </div>
    </div>
@endforeach
