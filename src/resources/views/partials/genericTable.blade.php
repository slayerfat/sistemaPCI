@if($data)
    <div class="container">
        @if($title)
            <h3>{{$title}}</h3>
        @endif

        {!!

        Table::withContents($data->getCollection()
            ->toArray())
            ->striped()->callback('Action', function ($id, $row) {
                return   "<a href=\"" . route('users.show', $row['Seudonimo']) . "\" data-toggle=\"tooltip\" title=\"Consultar\"><i class=\"fa fa-eye fa-fw alert-success\"></i></a>"
                        ."<a href=\"" . route('users.edit', $row['Seudonimo']) . "\" data-toggle=\"tooltip\" title=\"Editar\"><i class=\"fa fa-edit fa-fw\"></i></a>";
            })

        !!}

        {!! $data->render() !!}
    </div>
@else
    <div class="container">
        <h3>No hay información que mostrar.</h3>
    </div>
@endif
