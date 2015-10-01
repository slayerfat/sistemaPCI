<?php
if (!isset($edit)) {
    $edit = false;
}
if (!isset($delete)) {
    $delete = false;
}
?>

<h1>{{$title}}</h1>

{!!
Table::withContents($data)
    ->ignore(['uid'])
    ->callback('Acciones', function ($id, $row) use ($resource, $edit, $delete) {
        $showButton = Button::link()
            ->asLinkTo(route("$resource.show", $row['uid']))
            ->withIcon(Icon::create('eye'))
            ->withAttributes([
                'class' => 'text-success',
                'data-toggle' => 'tooltip',
                'title' => 'Consultar'
            ])->extraSmall();

        if ($edit === false) {
            return $showButton;
        }

        $editButton = Button::link()
            ->asLinkTo(route("$resource.edit", $row['uid']))
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
                'route' => ["$resource.destroy", $row['uid']],
                'method' => 'DELETE', 'id' => $row['uid']
            ]) . Form::close();

            return $buttons . $deleteButton . $deleteForm;
        }

        return  $buttons;
})
!!}
