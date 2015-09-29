<?php
if (!isset($delete)) {
    $delete = false;
}
?>

@if($data && !$data->getModel()->isEmpty())
    <div class="container">

        @include('partials.tables.title')
        {!!

        Table::withContents($data->getModel()->getCollection()->toArray())
            ->ignore(['uid'])
            ->striped()->callback('Acciones', function ($id, $row) use ($data, $delete) {

                $showButton = Button::link()
                                    ->asLinkTo(route($data->getRoutes()->show, $row['uid']))
                                    ->withIcon(Icon::create('eye'))
                                    ->withAttributes([
                                        'class' => 'text-success',
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Consultar'
                                    ])->extraSmall();

                $editButton = Button::link()
                                    ->asLinkTo(route($data->getRoutes()->edit, $row['uid']))
                                    ->withIcon(Icon::create('edit'))
                                    ->withAttributes([
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Editar'
                                    ])->extraSmall();

                $buttons = $showButton . $editButton;

                if ($delete === true) {
                    $deleteButton = Button::link()
                                        ->asLinkTo('#')
                                        ->withIcon(Icon::create('trash-o'))
                                        ->withAttributes([
                                            'onClick' => "deleteResourceFromAnchor({$row['uid']})",
                                            'class' => 'text-danger',
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Eliminar'
                                        ])->extraSmall();

                    $deleteForm = Form::open([
                            'route' => [$data->getRoutes()->destroy, $row['uid']],
                            'method' => 'DELETE', 'id' => $row['uid']
                    ]) . Form::close();

                    return $buttons . $deleteButton . $deleteForm;
                }

                return  $buttons;
            })

        !!}

        {!! $data->getModel()->render() !!}
    </div>
@else
    <div class="container">

        @include('partials.tables.title')

        {!!

        Table::withContents([['Informacion' => 'No hay información que mostrar.']])
            ->striped()

        !!}
    </div>
@endif
