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
                {{trans('defaults.users.show')}}
            </a>
        </li>

        @if(Auth::user()->isOwnerOrAdmin($user->id))
            <li {{isset($randVar) ? $randVar : null}}>
                <a href="#">--</a>
            </li>
        @endif
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
                <a href="#">--</a>
                {{-- link_to_action($user->person ? 'PeopleController@edit':'PeopleController@create', 'Información Personal', $user->name) --}}
            </li>

            <li>
                <a href="#">Mas pronto!</a>
            </li>
        </ul>
    @endif
</div>
