<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            {{--            <li class="nav-title">--}}
            {{--                @lang('menus.backend.sidebar.general')--}}
            {{--            </li>--}}
            <li class="nav-item">
                <a class="nav-link {{
                    active_class(Active::checkUriPattern('admin/dashboard'))
                }}" href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    @lang('menus.backend.sidebar.dashboard')
                </a>
            </li>

            <li class="nav-title">
                @lang('menus.backend.sidebar.system')
            </li>

            @if ($logged_in_user->isAdmin())
                <li class="nav-item nav-dropdown {{
                    active_class(Active::checkUriPattern('admin/auth*'), 'open')
                }}">
                    <a class="nav-link nav-dropdown-toggle {{
                        active_class(Active::checkUriPattern('admin/auth*'))
                    }}" href="#">
                        <i class="nav-icon far fa-user"></i>
                        @lang('menus.backend.access.title')
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{
                                active_class(Active::checkUriPattern('admin/auth/user'))
                            }}" href="{{ route('admin.auth.user.index') }}">
                                @lang('labels.backend.access.users.management')
                            </a>
                        </li>

                        @if (config('access.users.requires_approval') || config('access.users.confirm_email'))
                            @if ($pending_approval > 0)
                                <li class="nav-item">
                                    <a class="nav-link {{
                                active_class(Active::checkUriPattern('admin/auth/user/pending*'))
                            }}" href="{{ route('admin.auth.user.pending') }}">
                                        @lang('menus.backend.access.users.pending')
                                        <span class="badge badge-danger">{{ $pending_approval }}</span>
                                    </a>
                                </li>
                            @endif
                        @endif

                        <li class="nav-item">
                            <a class="nav-link {{
                                active_class(Active::checkUriPattern('admin/auth/role*'))
                            }}" href="{{ route('admin.auth.role.index') }}">
                                @lang('labels.backend.access.roles.management')
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{
                                active_class(Active::checkUriPattern('admin/auth/team'))
                            }}" href="{{ route('admin.auth.team.index') }}">
                                @lang('labels.backend.access.teams.management')
                            </a>
                        </li>

                    </ul>
                </li>
            @endif

            <li class="divider"></li>

            <li class="nav-item nav-dropdown {{
                active_class(Active::checkUriPattern('admin/log-viewer*'), 'open')
            }}">
                <a class="nav-link nav-dropdown-toggle {{
                    active_class(Active::checkUriPattern('admin/log-viewer*'))
                }}" href="#">
                    <i class="nav-icon fas fa-list"></i> @lang('menus.backend.log-viewer.main')
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{
                            active_class(Active::checkUriPattern('admin/log-viewer'))
                        }}" href="{{ route('log-viewer::dashboard') }}">
                            @lang('menus.backend.log-viewer.dashboard')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{
                            active_class(Active::checkUriPattern('admin/log-viewer/logs*'))
                        }}" href="{{ route('log-viewer::logs.list') }}">
                            @lang('menus.backend.log-viewer.logs')
                        </a>
                    </li>
                </ul>
            </li>

            <li class="divider"></li>

        </ul>
    </nav>

    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div><!--sidebar-->
