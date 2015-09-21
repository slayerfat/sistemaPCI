<?php
switch ($active) {
    case '.show':
        $show = 'class=active';
        break;

    default:
        $show = 'class=sidebar-danger';
        Log::warning('users.partials.sidebar: no se pudo identificar el vinculo activo');
        break;
}
?>

<div class="col-sm-2 sidebar">
    <ul class="nav nav-sidebar">
        <li {{$show or null}}>
            <a href="{{isset($show) ? '#' : route('users.show')}}">
                {{trans('models.users.show')}}
            </a>
        </li>
    </ul>

    @if(Auth::user()->isOwnerOrAdmin($user->id))
        <ul class="nav nav-sidebar">
            <li class="sidebar-header">
                Editar
            </li>

            <li>
                {!! link_to_route('users.edit', 'Cuenta', $user->name) !!}
            </li>

            <li>
                <a href="{{route($user->person ? 'employees.edit' : 'employees.create', $user->name)}}">
                    {{trans('models.employees.singular')}}
                </a>
            </li>

            @can('destroy', $user)
                <li class="sidebar-danger">
                    {!!

                    Form::open([
                        'method' => 'DELETE',
                        'route' => ['users.destroy', $user->id],
                        'class' => 'hidden',
                        'id' => "destroy-element-{$user->id}"
                    ])

                    !!}

                    {!! Form::close() !!}

                    <a href="#"
                       onclick="deleteResourceFromAnchor('destroy-element-{{$user->id}}')"
                        >
                        {{trans('models.users.destroy')}}
                    </a>
                </li>
            @endcan

            <li class="disabled">
                <a href="#">Mas pronto!</a>
            </li>
        </ul>
    @endif
</div>
