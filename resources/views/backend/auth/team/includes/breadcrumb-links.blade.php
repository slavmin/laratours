<li class="breadcrumb-menu">
    <div class="btn-group" role="group" aria-label="Button group">
        <div class="dropdown">
            <a class="btn dropdown-toggle" href="#" role="button" id="breadcrumb-dropdown-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('menus.backend.access.teams.main')</a>

            <div class="dropdown-menu align-self-right" aria-labelledby="breadcrumb-dropdown-1">
                <a class="dropdown-item" href="{{ route('admin.auth.team.index') }}">@lang('menus.backend.access.teams.all')</a>
                <a class="dropdown-item" href="{{ route('admin.auth.team.create') }}">@lang('menus.backend.access.teams.create')</a>
{{--                <a class="dropdown-item" href="{{ route('admin.auth.team.deactivated') }}">@lang('menus.backend.access.teams.deactivated')</a>--}}
                <a class="dropdown-item" href="{{ route('admin.auth.team.deleted') }}">@lang('menus.backend.access.teams.deleted')
                    @if ($count_deleted_teams > 0)<span class="badge badge-info">{{ $count_deleted_teams }}</span>@endif</a>
            </div>
        </div><!--dropdown-->

    </div><!--btn-group-->
</li>
