<li class="breadcrumb-menu">
    <div class="btn-group" role="group" aria-label="Button group">
        <div class="dropdown">
            <a class="btn dropdown-toggle" href="#" role="button" id="breadcrumb-dropdown-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('menus.backend.access.users.main')</a>

            <div class="dropdown-menu align-self-right" aria-labelledby="breadcrumb-dropdown-1">
                <a class="dropdown-item" href="{{ route('admin.auth.user.index') }}">@lang('menus.backend.access.users.all')</a>
                <a class="dropdown-item" href="{{ route('admin.auth.user.create') }}">@lang('menus.backend.access.users.create')</a>
                <a class="dropdown-item" href="{{ route('admin.auth.user.deactivated') }}">@lang('menus.backend.access.users.deactivated')
                    @if ($count_inactive_users > 0)<span class="badge badge-info">{{ $count_inactive_users }}</span>@endif</a>
                <a class="dropdown-item" href="{{ route('admin.auth.user.deleted') }}">@lang('menus.backend.access.users.deleted')
                    @if ($count_deleted_users > 0)<span class="badge badge-info">{{ $count_deleted_users }}</span>@endif</a>
            </div>
        </div><!--dropdown-->

    </div><!--btn-group-->
</li>
