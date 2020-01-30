<nav class="navbar navbar-expand-lg navbar-dark tc-navbar">
    <a href="/dashboard" class="mr-2">
        <img src="/img/frontend/logo_small.png">
    </a>
    @auth
        <branding></branding>
    @endauth
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
                <li class="nav-item">
                    <a 
                        href="{{route('frontend.user.dashboard')}}" 
                        class="nav-link {{ active_class(Active::checkRoute('frontend.user.dashboard')) }}"
                    >
                        <i aria-hidden="true" class="v-icon mr-2 material-icons theme--dark">dashboard</i>
                        @lang('navs.frontend.dashboard')
                    </a>
                </li>
            @endauth

            @guest
                <li class="nav-item"><a href="{{route('frontend.auth.login')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.auth.login')) }}">@lang('navs.frontend.login')</a></li>

                @if(config('access.registration'))
                    <li class="nav-item"><a href="{{route('frontend.auth.register')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.auth.register')) }}">@lang('navs.frontend.register')</a></li>
                @endif
            @else
                @can('administer-tours')
                    <li class="nav-item dropdown">
                        <a 
                            href="#" 
                            class="nav-link dropdown-toggle" 
                            id="navbarDropdownMenuTour" 
                            data-toggle="dropdown"
                            aria-haspopup="true" 
                            aria-expanded="false"
                        >
                           <i aria-hidden="true" class="v-icon mr-2 material-icons theme--dark">
                               work_outline
                            </i>
                            @lang('labels.frontend.tours.management')
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuTour">
                            {{--@can('order-manage')--}}
                            <a href="{{ route('frontend.tour.order.index') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.tour.order.index')) }}">
                                @lang('labels.frontend.tours.order.management')</a>
                            {{--@endcan--}}
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
                            <a href="{{ route('frontend.tour.hotel.index') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.tour.hotel.index')) }}">
                                @lang('labels.frontend.tours.hotel.management')</a>
                            <a href="{{ route('frontend.tour.museum.index') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.tour.museum.index')) }}">
                                @lang('labels.frontend.tours.museum.management')</a>
                            <a href="{{ route('frontend.tour.meal.index') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.tour.meal.index')) }}">
                                @lang('labels.frontend.tours.meal.management')</a>
                            <a href="{{ route('frontend.tour.transport.index') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.tour.transport.index')) }}">
                                @lang('labels.frontend.tours.transport.management')</a>
                            <a href="{{ route('frontend.tour.guide.index') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.tour.guide.index')) }}">
                                @lang('labels.frontend.tours.guide.management')</a>
                            <a href="{{ route('frontend.tour.attendant.index') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.tour.attendant.index')) }}">
                                @lang('labels.frontend.tours.attendant.management')</a>
                        </div>
                    </li>
                @endcan
                @can('administer-orders')
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuTour" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">@lang('labels.frontend.tours.management')</a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuTour">
                            <a href="{{ route('frontend.agency.tour-list') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.agency.tour-list')) }}">
                                @lang('labels.frontend.tours.tour.management')</a>
                            <a href="{{ route('frontend.agency.order.index') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.agency.order.index')) }}">
                                @lang('labels.frontend.tours.order.management')</a>
                        </div>
                    </li>
                @endcan
                <li class="nav-item dropdown">
                    <a 
                        href="#" 
                        class="nav-link dropdown-toggle" 
                        id="navbarDropdownMenuUser" 
                        data-toggle="dropdown"
                        aria-haspopup="true" 
                        aria-expanded="false"
                    >
                        <i aria-hidden="true" class="v-icon mr-2 material-icons theme--dark">
                            account_circle
                        </i>
                        {{ $logged_in_user->name }}
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuUser">
                        @can('view backend')
                            <a href="{{ route('admin.dashboard') }}" class="dropdown-item">@lang('navs.frontend.user.administration')</a>
                        @endcan

                        @if($logged_in_user->isTeamOwner())
                                <a href="{{ route('frontend.user.team') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.user.team')) }}">@lang('navs.frontend.user.team')</a>
                        @endif

                        <a href="{{ route('frontend.user.account') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.user.account')) }}">@lang('navs.frontend.user.account')</a>
                        <a href="{{ route('frontend.document.index') }}" class="dropdown-item">@lang('labels.frontend.document.management')</a>
                        <a href="{{ route('frontend.auth.logout') }}" class="dropdown-item">@lang('navs.general.logout')</a>
                    </div>
                </li>
            @endguest

            <li class="nav-item dropdown">
                <a 
                    href="#" 
                    class="nav-link dropdown-toggle" 
                    id="navbarDropdownMenuInfo" 
                    data-toggle="dropdown"
                    aria-haspopup="true" 
                    aria-expanded="false"
                >
                    <i aria-hidden="true" class="v-icon mr-2 material-icons theme--dark">
                        help_outline
                    </i>
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuInfo">
                    <a 
                        href="{{ route('frontend.contact') }}" 
                        class="dropdown-item"
                    >
                        @lang('navs.frontend.contact')
                    </a>
                    @auth
                        <Changelog />
                    @endauth
                </div>
            </li>    
        </ul>
    </div>
</nav>
{{-- 
@auth
    <nav-bar-status
        status="auth"
        :flag="true"
        name="{{ $logged_in_user->name }}"
    ></nav-bar-status>
@else  
    <nav-bar-status
        status="auth"
        :flag="false"
    ></nav-bar-status>
@endauth
@guest
    <nav-bar-status
        status="guest"
        :flag="true"
    ></nav-bar-status>
@else  
    <nav-bar-status
        status="guest"
        :flag="false"
    ></nav-bar-status>
@endguest
@can('administer-tours')
    <nav-bar-status
        status="operator"
        :flag="true"
    ></nav-bar-status>
@endcan
@can('administer-orders')
    <nav-bar-status
        status="agency"
        :flag="true"
    ></nav-bar-status>
@endcan

<nav-bar
    login-url="{{route('frontend.auth.login')}}"
    login-text="@lang('navs.frontend.login')"
    reg-url="{{route('frontend.auth.register')}}"
    reg-text="@lang('navs.frontend.register')"
    dashboard-url="{{route('frontend.user.dashboard')}}"
    dashboard-text="@lang('navs.frontend.dashboard')"
    management-text="@lang('labels.frontend.tours.management')"
    order-index-url="{{ route('frontend.tour.order.index') }}" 
    order-index-text="@lang('labels.frontend.tours.order.management')"
    tour-index-url="{{ route('frontend.tour.tour.index') }}"
    tour-index-text="@lang('labels.frontend.tours.tour.management')"
    tour-type-index-url="{{ route('frontend.tour.type.index') }}"
    tour-type-index-text="@lang('labels.frontend.tours.type.management')"
    tour-customer-index-url="{{ route('frontend.tour.customer-type.index') }}"
    tour-customer-index-text="@lang('labels.frontend.tours.customer.type.management')"
    tour-hotel-category-index-url="{{ route('frontend.tour.hotel-category.index') }}"
    tour-hotel-category-index-text="@lang('labels.frontend.tours.hotel.category.management')"
    tour-country-index-url="{{ route('frontend.tour.country.index') }}"
    tour-country-index-text="@lang('labels.frontend.tours.country.management') / @lang('labels.frontend.tours.city.management')"
    tour-hotel-index-url="{{ route('frontend.tour.hotel.index') }}"
    tour-hotel-index-text="@lang('labels.frontend.tours.hotel.management')"
    tour-museum-index-url="{{ route('frontend.tour.museum.index') }}"
    tour-museum-index-text="@lang('labels.frontend.tours.museum.management')"
    tour-meal-index-url="{{ route('frontend.tour.meal.index') }}"
    tour-meal-index-text="@lang('labels.frontend.tours.meal.management')"
    tour-transport-index-url="{{ route('frontend.tour.transport.index') }}"
    tour-transport-index-text="@lang('labels.frontend.tours.transport.management')"
    tour-guide-index-url="{{ route('frontend.tour.guide.index') }}"
    tour-guide-index-text="@lang('labels.frontend.tours.guide.management')"
    tour-attendant-index-url="{{ route('frontend.tour.attendant.index') }}"
    tour-attendant-index-text="@lang('labels.frontend.tours.attendant.management')"
    user-team-url="{{ route('frontend.user.team') }}"
    user-team-text="@lang('navs.frontend.user.team')"
    user-account-url="{{ route('frontend.user.account') }}"
    user-account-text="@lang('navs.frontend.user.account')"
    auth-logout-url="{{ route('frontend.auth.logout') }}"
    auth-logout-text="@lang('navs.general.logout')"
    contact-url="{{route('frontend.contact')}}"
    contact-text="@lang('navs.frontend.contact')"
    agency-tour-list-url="{{ route('frontend.agency.tour-list') }}" 
    agency-tour-list-text="@lang('labels.frontend.tours.tour.management')"
    agency-order-index-url="{{ route('frontend.agency.order.index') }}"
    agency-order-index-text="@lang('labels.frontend.tours.order.management')"
    documents-index-url="{{ route('frontend.document.index') }}"
    documents-index-text="@lang('labels.frontend.document.management')"
></nav-bar> --}}