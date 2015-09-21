<h3>
    {{$title}}
    <a href="{{route(trans($data->getRoutes()->create))}}">
        <button class="btn btn-primary">
            <i class="fa fa-plus-circle"></i>
            &nbsp;
            {{trans($data->getTrans()->create)}}
        </button>
    </a>
</h3>
