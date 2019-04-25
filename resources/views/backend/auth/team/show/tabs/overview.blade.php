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
        @foreach($team->users as $user)
            <ul class="list-unstyled">
                @if($user->isOwnerOfTeam($team))
                    <li class="media team-owner mb-2 p-2 border border-light">
                        <img src="{{ $user->avatar }}" class="mr-3" alt="...">
                        <div class="media-body">
                            <h5 class="mt-0">{{$user->name}}</h5>
                            <div class="mb-2">{{$user->email}}</div>
                            <div><strong>@lang('labels.backend.access.teams.table.owner')</strong></div>
                        </div>
                    </li>
                @else
                    <li class="media team-member mb-2 p-2 border border-light">
                        <img src="{{ $user->avatar }}" class="mr-3" alt="...">
                        <div class="media-body">
                            <h5 class="mt-0">{{$user->name}}</h5>
                            <div class="mb-2">{{$user->email}}</div>
                        </div>
                    </li>
                @endif
            </ul>
        @endforeach
    </div>
</div><!--col-->
