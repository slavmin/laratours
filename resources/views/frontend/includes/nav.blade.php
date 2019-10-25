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
    data-app
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
></nav-bar>