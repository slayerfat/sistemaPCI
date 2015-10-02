@if(Auth::user()->isAdmin())
    <hr/>

    <h4>
        {{$created or 'Recurso creado'}}
        {{$model->created_at->diffForHumans()}}
        <small>
            por
            <a href="{{route("{$resource}.show", $model->createdBy()->name)}}">
                {{$model->createdBy()->name}}
            </a>
        </small>
    </h4>

    <h4>
        {{$updated or 'Recurso actualizado'}}
        {{$model->created_at->diffForHumans()}}
        <small>
            por
            <a href="{{route("{$resource}.show", $model->updatedBy()->name)}}">
                {{$model->updatedBy()->name}}
            </a>
        </small>
    </h4>
@endif
