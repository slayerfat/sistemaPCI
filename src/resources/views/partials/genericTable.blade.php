@if($data)
    <div class="container">
        {!!

        Table::withContents($data->getCollection()->toArray())->striped()

        !!}

        {!! $data->render() !!}
    </div>
@else
    <div class="container">
        <h1>No hay información que mostrar.</h1>
    </div>
@endif
