<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <a href="{{ route('frontend.index') }}" class="navbar-brand">{{ app_name() }}</a>

    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="@lang('labels.general.toggle_navigation')">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
        <ul class="navbar-nav">
            @if(config('locale.status') && count(config('locale.languages')) > 1)
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownLanguageLink" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">@lang('menus.language-picker.language') ({{ strtoupper(app()->getLocale()) }})</a>

                    @include('includes.partials.lang')
                </li>
            @endif

            @auth
                <li class="nav-item"><a href="{{route('frontend.user.dashboard')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.user.dashboard')) }}">@lang('navs.frontend.dashboard')</a></li>
            @endauth

            @guest
                <li class="nav-item"><a href="{{route('frontend.auth.login')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.auth.login')) }}">@lang('navs.frontend.login')</a></li>

                @if(config('access.registration'))
                    <li class="nav-item"><a href="{{route('frontend.auth.register')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.auth.register')) }}">@lang('navs.frontend.register')</a></li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuTour" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">@lang('labels.frontend.tours.management')</a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuTour">
                        <a href="{{ route('frontend.tour.tour.index') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.tour.tour.index')) }}">
                            @lang('labels.frontend.tours.tour.management')</a>
                        <a href="{{ route('frontend.tour.type.index') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.tour.type.index')) }}">
                            @lang('labels.frontend.tours.type.management')</a>
                        <a href="{{ route('frontend.tour.customer-type.index') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.tour.customer-type.index')) }}">
                            @lang('labels.frontend.tours.customer.type.management')</a>
                        <a href="{{ route('frontend.tour.hotel-category.index') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.tour.hotel-category.index')) }}">
                            @lang('labels.frontend.tours.hotel.category.management')</a>
                        <a href="{{ route('frontend.tour.country.index') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.tour.country.index')) }}">
                            @lang('labels.frontend.tours.country.management') / @lang('labels.frontend.tours.city.management')</a>
                        <a href="{{ route('frontend.tour.guide.index') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.tour.guide.index')) }}">
                            @lang('labels.frontend.tours.guide.management')</a>
                        <a href="{{ route('frontend.tour.attendant.index') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.tour.attendant.index')) }}">
                            @lang('labels.frontend.tours.attendant.management')</a>
                        <a href="{{ route('frontend.tour.hotel.index') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.tour.hotel.index')) }}">
                            @lang('labels.frontend.tours.hotel.management')</a>
                        <a href="{{ route('frontend.tour.museum.index') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.tour.museum.index')) }}">
                            @lang('labels.frontend.tours.museum.management')</a>
                        <a href="{{ route('frontend.tour.meal.index') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.tour.meal.index')) }}">
                            @lang('labels.frontend.tours.meal.management')</a>
                        <a href="{{ route('frontend.tour.transport.index') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.tour.transport.index')) }}">
                            @lang('labels.frontend.tours.transport.management')</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuUser" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">{{ $logged_in_user->name }}</a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuUser">
                        @can('view backend')
                            <a href="{{ route('admin.dashboard') }}" class="dropdown-item">@lang('navs.frontend.user.administration')</a>
                        @endcan

                        @if($logged_in_user->isTeamOwner())
                                <a href="{{ route('frontend.user.team') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.user.team')) }}">@lang('navs.frontend.user.team')</a>
                        @endif

                        <a href="{{ route('frontend.user.account') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.user.account')) }}">@lang('navs.frontend.user.account')</a>
                        <a href="{{ route('frontend.auth.logout') }}" class="dropdown-item">@lang('navs.general.logout')</a>
                    </div>
                </li>
            @endguest

            <li class="nav-item"><a href="{{route('frontend.contact')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.contact')) }}">@lang('navs.frontend.contact')</a></li>
        </ul>
    </div>
</nav>
