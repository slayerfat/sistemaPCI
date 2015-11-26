<div class="row">
    <div class="col-xs-12">
        <h4>
            <span>
                Del Tipo

                {!!link_to_route('itemTypes.show', $item->type->desc, $item->type->slug)!!}
            </span>

            <span>
                Fabricado por

                {!!link_to_route('makers.show', $item->maker->desc, $item->maker->slug)!!}
            </span>
        </h4>
    </div>
</div>
