<table style="border: 1px solid #333; border-collapse: collapse; width: 100%;">
    <thead>
    <tr>
        <th style=" border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #dedede;">
            #
        </th>
        <th style=" border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #dedede;">
            Item
        </th>
        <th style=" border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #dedede;">
            Fecha Vto.
        </th>
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
            <?php
                $pivot = $details->item->notes()->whereNoteId($note->id)->first()->pivot;
            ?>
            <tr>
                <td style="border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #ffffff;">{{ $details->item->id }}</td>
                <td style="border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #ffffff;">
                    {!! link_to_route('items.show', $details->item->desc, $details->item->slug) !!}
                </td>
                <td style="border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #ffffff;">
                    {{ $pivot->due }}
                    <i>{{ Date::parse($pivot->due)->diffForHumans() }}</i>
                </td>
                @if($movement->type->isIn())
                    <td style="border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #ffffff; color: #5CB85C;">+{{ $pivot->quantity }}</td>
                @else
                    <td style="border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #ffffff; color: #D9534F;">-{{ $pivot->quantity }}</td>
                @endif
                <td style="border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #ffffff;">{{ $details->item->formattedStock() }}</td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>
