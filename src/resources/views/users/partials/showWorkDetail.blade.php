@if($user->employee && $user->employee->workDetails)
    <section class="workDetails.show">
        <div class="row">
            <div class="col-xs-6">
                <h4>
                    {{trans('models.positions.singular')}}:
                </h4>

                <p>
                    {{$user->employee->workDetails->position->desc}}
                </p>
            </div>

            <div class="col-xs-6">
                <h4>
                    {{trans('models.depts.singular')}}:
                </h4>

                <p>
                    {{$user->employee->workDetails->department->desc}}
                </p>
            </div>
        </div>
        @if(Auth::user()->isOwnerOrAdmin($user->id))

            <hr/>

        @if(Auth::user()->isAdmin())
                <h4>
                    Fecha de ingreso:

                    {{$user->employee->workDetails->join_date->diffForHumans() . '.'}}

                    <br/>

                    <small>
                        {{$user->employee->workDetails->join_date->format('Y-m-d')}}
                    </small>
                </h4>

                <h4>
                    Fecha de egreso:

                    {{$user->employee->workDetails->departure_date->diffForHumans() . '.'}}

                    <br/>

                    <small>
                        {{$user->employee->workDetails->departure_date->format('Y-m-d')}}
                    </small>
                </h4>
            @endif
        @endif
    </section>
@endif
