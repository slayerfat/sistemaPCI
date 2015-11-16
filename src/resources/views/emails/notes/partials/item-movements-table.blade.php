<table style="border: 1px solid #333; border-collapse: collapse; width: 100%;">
    <thead>
    <tr>
        <th style=" border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #dedede;">
            #
        </th>
        <th style=" border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #dedede;">
            Item
        </th>
        @if($movement->type->isIn())
            <th style=" border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #dedede;">
                Fecha de Vto.
            </th>
        @endif
        <th style=" border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #dedede;">
            Movimiento
        </th>
        <th style=" border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #dedede;">
            Nuevo Stock
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($note->movements as $movement)
            @foreach($movement->itemMovements as $details)
            <tr>
                <td style="border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #ffffff;">{{ $details->item->id }}</td>
                <td style="border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #ffffff;">
                    {!! link_to_route('items.show', $details->item->desc, $details->item->slug) !!}
                </td>
                @if($movement->type->isIn())
                    <td style="border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #ffffff;">
                        @if ($details->due)
                            {{ $details->due->toDateString() }}
                        @else
                            <small><i>Sin fecha.</i></small>
                        @endif
                        <i>{{ $details->due ? $details->due->diffForHumans() : null }}</i>
                    </td>
                    <td style="border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #ffffff; color: #5CB85C;">+{{ $details->quantity }}</td>
                @else
                    <td style="border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #ffffff; color: #D9534F;">-{{ $details->quantity }}</td>
                @endif
                <td style="border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #ffffff;">{{ $details->item->formattedStock() }}</td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>
