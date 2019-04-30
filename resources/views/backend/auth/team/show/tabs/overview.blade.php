<div class="col">
    <div class="table-responsive" style="min-height: 0">
        <table class="table" style="margin-bottom: 0">
            <tr>
                <th>@lang('labels.backend.access.teams.tabs.content.overview.name')</th>
                <td>{{ $team->name }}</td>
            </tr>

            <tr>
                <th>@lang('labels.backend.access.teams.table.number_of_users')</th>
                <td>{{ $team->users->count() }}</td>
            </tr>

            <tr>
                <th colspan="2">@lang('labels.backend.access.teams.tabs.content.overview.members')</th>
            </tr>

        </table>
    </div><!--table-responsive-->
    <div>
        <ul class="list-unstyled">
            @foreach($team->users as $user)
                @if($user->isOwnerOfTeam($team))
                    <li class="media team-owner mb-2 p-2 border border-light">
                        <img src="{{ $user->avatar }}" class="mr-3" alt="...">
                        <div class="media-body position-relative">
                            <h5 class="mt-0 user-name">{{$user->name}}</h5>
                            <div class="mb-2 user-mail">{{$user->email}}</div>
                            <div><strong>@lang('labels.backend.access.teams.table.owner')</strong></div>
                            <div class="user-button-group position-absolute" style="top: 0; right: 0">{!! $user->action_buttons !!}</div>
                        </div>
                    </li>
                @endif
                @if(!$user->isOwnerOfTeam($team))
                    <li class="media team-member mb-2 p-2 border border-light">
                        <img src="{{ $user->avatar }}" class="mr-3" alt="...">
                        <div class="media-body position-relative">
                            <h5 class="mt-0 user-name">{{$user->name}}</h5>
                            <div class="mb-2 user-mail">{{$user->email}}</div>
                            <div class="user-button-group position-absolute" style="top: 0; right: 0">{!! $user->action_buttons !!}</div>
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div><!--col-->
