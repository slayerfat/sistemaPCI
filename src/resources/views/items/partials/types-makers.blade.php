<div class="row">
    <div class="col-xs-4">
        <h4>
            Del Tipo

            {!!link_to_route('itemTypes.show', $item->type->desc, $item->type->slug)!!}
        </h4>
    </div>

    <div class="col-xs-8">
        <h4>
            Fabricado por

            {!!link_to_route('makers.show', $item->maker->desc, $item->maker->slug)!!}
        </h4>
    </div>
</div>
