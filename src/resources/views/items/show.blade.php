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

        @include('items.partials.types-makers')

        <hr/>

        @include('items.partials.stock-progressbar', ['title' => 'Stock'])
        @include('items.partials.reserved-progressbar', [
            'title' => 'Existencia vs Reservaciones'
        ])

        <hr/>

        @include('items.partials.priority-progressbar')

        @include('items.partials.abc')
    </div>

    <div class="col-sm-4">
        @include('items.partials.movements-table')
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
