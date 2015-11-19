@extends('master')

@section('content')
<div class="container">
    <div class="col-sm-8">
        <h1>
            {{$item->desc}}

            <hr/>

            @include(
                'partials.buttons.edit-delete',
                ['resource' => 'items', 'id' => $item->id]
            )
        </h1>

        <hr/>

        <h2>
            En
            {!!link_to_route('subCats.show', $item->subCategory->desc, $item->subCategory->slug)!!}
        </h2>

        <div class="row">
            <div class="col-xs-6">
                <h4>
                    Tipo:
                </h4>

                <p>
                    {!!link_to_route('itemTypes.show', $item->type->desc, $item->type->slug)!!}
                </p>
            </div>

            <div class="col-xs-6">
                <h4>
                    {{trans('models.makers.singular')}}:
                </h4>

                <p>
                    {!!link_to_route('makers.show', $item->maker->desc, $item->maker->slug)!!}
                </p>
            </div>
        </div>

        <hr/>

        @include('items.partials.stock-progressbar', ['title' => 'Stock'])
        @include('items.partials.reserved-progressbar', [
            'title' => 'Existencia vs Reservaciones'
        ])

        @include('items.partials.abc')
    </div>

    <div class="col-sm-4">
        <h1>Ultimos Movimientos</h1>
        <?php //TODO: movimientos en vista de item ?>
    </div>
</div>

<div class="container">
    <div class="col-xs-12">
        @include('items.partials.depots')

        @include('partials.admins.show-basic-audit', [
            'model'    => $item,
            'created'  => trans('models.items.singular') . ' creado',
            'updated'  => trans('models.items.singular') . ' actualizado',
        ])
    </div>
</div>
@stop
