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
            Cantidad
        </th>
        <th style=" border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #dedede;">
            Stock
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($petition->items as $item)
        <tr>
            <td style="border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #ffffff;">{{ $item->id }}</td>
            <td style="border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #ffffff;">
                {!! link_to_route('items.show', $item->desc, $item->slug) !!}
            </td>
            @if($petition->type->movementType->isIn())
                <td style="border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #ffffff; color: #5CB85C;">+{{ $item->pivot->quantity }}</td>
            @else
                <td style="border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #ffffff; color: #D9534F;">-{{ $item->pivot->quantity }}</td>
            @endif
            <td style="border-width: 1px; padding: 8px; border-style: solid; border-color: #666666; background-color: #ffffff;">{{ $item->formattedStock() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
