<?php
if (!isset($edit)) {
    $edit = false;
}

if (!isset($delete)) {
    $delete = false;
}

if (!isset($title)) {
    $title = false;
}

if (!isset($empty)) {
    $empty = ['Información' => 'No hay información que mostrar.'];
}

if (isset($total) && isset($data)) {
    // se determina el col con el tamaño del array
    // -2 por el uid
    if (count($data) > 0) {
        $col = count($data[0]) - 2;

        // el HTML del footer
        $footer = "<tr>
                   <td colspan=\"$col\"><strong>Total</strong></td>
                   <td colspan=\"2\"><strong>$total</strong></td>
               </td>";
    } else {
        $footer = '';
    }
} elseif (!isset($total)) {
    $footer = '';
}

$html = $title ? "<h1>{$title}</h1>" : '';

?>

{!! $html !!}

@if (count($data) > 1)
{!!
Table::withContents($data)->withFooter($footer)
    ->ignore(['uid'])
    ->callback('Acciones', function ($id, $row) use ($resource, $edit, $delete) {
        $showButton = Button::link()
            ->asLinkTo(route("$resource.show", $row['uid']))
            ->withIcon(Icon::create('eye'))
            ->withAttributes([
                'class' => 'text-success',
                'id' => 'model-show-' . $row['uid'],
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
                'id' => 'model-edit-' . $row['uid'],
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
                    'id' => 'model-delete-' . $row['uid'],
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
    ->striped()
!!}
@else
    {!!

    Table::withContents([$empty])
        ->striped()

    !!}
@endif
