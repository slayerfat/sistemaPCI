@if($data)
    <div class="container">
        @if($title)
            <h3>{{$title}}</h3>
        @endif


        {!!

        Table::withContents($data->getModel()->getCollection()->toArray())
            ->ignore(['uid'])
            ->striped()->callback('Action', function ($id, $row) use ($data) {
                return   "<a href=\"" . route($data->getRoutes()->show, $row['uid']) . "\" data-toggle=\"tooltip\" title=\"Consultar\"><i class=\"fa fa-eye fa-fw alert-success\"></i></a>"
                        ."<a href=\"" . route($data->getRoutes()->edit, $row['uid']) . "\" data-toggle=\"tooltip\" title=\"Editar\"><i class=\"fa fa-edit fa-fw\"></i></a>";
            })

        !!}

        {!! $data->getModel()->render() !!}
    </div>
@else
    <div class="container">
        {!!

        Table::withContents([['Informacion' => 'No hay información que mostrar.']])
            ->striped()

        !!}
    </div>
@endif
