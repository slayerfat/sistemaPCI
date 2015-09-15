@if(!$user->employee)
    <h1>
        --
    </h1>

    @if(!Auth::user()->isAdmin())
        <h2>
            --
        </h2>
        <h3>
            --
        </h3>

        <h4>
            Usuario creado
            {{$user->created_at->diffForHumans()}}
            <small>
                {{$user->created_at}} por
                <a href="{{route('users.show', $user->createdBy()->name)}}">
                    {{$user->createdBy()->name}}
                </a>
            </small>
        </h4>

        @unless(false)
            <h4>
                Usuario actualizado
                {{$user->created_at->diffForHumans()}}
                <small>
                    {{$user->updated_at}} por
                    <a href="{{route('users.show', $user->updatedBy()->name)}}">
                        {{$user->updatedBy()->name}}
                    </a>
                </small>
            </h4>
        @endunless
    @endif
@endif
