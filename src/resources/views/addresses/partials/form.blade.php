{!!

ControlGroup::generate(
    BSForm::label('building', 'Edificio'),
    BSForm::text('building'),
    BSForm::help('&nbsp;'),
    3
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('street', 'Calle'),
    BSForm::text('street'),
    BSForm::help('&nbsp;'),
    3
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('av', 'Avenida'),
    BSForm::text('av'),
    BSForm::help('&nbsp;'),
    3
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('state_id', 'Estado'),
    BSForm::select('state_id'),
    BSForm::help('&nbsp;'),
    3
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('town_id', 'Municipio'),
    BSForm::select('town_id'),
    BSForm::help('&nbsp;'),
    3
)

!!}

{{--se tiene que hacer esta mamarrachada mientras tanto--}}
<?php $id = $address->exists() ? $address->id : null ?>

<div class="form-group">
    <label for="parish_id" class="control-label col-sm-3">Parroquia</label>

    <div class="col-sm-9">
        <select class="form-control" id="parish_id" name="parish_id">
            <option value="{{$id}}"></option>
        </select>
        <span class="help-block">&nbsp;</span>
    </div>
</div>


{!! Button::primary($btnMsg)->block()->submit() !!}
