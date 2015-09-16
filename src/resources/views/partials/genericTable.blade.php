@if($data)
    <div class="container">
        {!!

        Table::withContents($data)->striped()

        !!}
    </div>
@else
    <div class="container">
        <h1>No hay información que mostrar.</h1>
    </div>
@endif
