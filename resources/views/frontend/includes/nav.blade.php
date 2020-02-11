@push('before-scripts')
<script>
  window.onload = function () {
    let header = document.getElementById('tc-main-header')
    let menu = document.getElementById('tc-main-menu')
    let showMenu = false
    const burgerBtn = document.getElementById('tc-main-menu-burger')
    burgerBtn.onclick = () =>  {
      header.classList.toggle('tc-expand-header')
      menu.classList.toggle('d-none')
      menu.classList.toggle('tc-show-menu-on-burger')
      menu.classList.toggle('tc-main-header')
      showMenu = !showMenu
    }
  }
</script>
@endpush
<v-toolbar id="tc-main-header" class="tc-main-header">
  <v-toolbar-title>
    <a href="/dashboard">
      <img src="/img/frontend/logo_small.png">
    </a>
  </v-toolbar-title>
  <v-spacer></v-spacer>
  <ul id="tc-main-menu" class="tc-main-menu justify-end align-center d-none d-lg-flex">
    {{-- @if(config('locale.status') && count(config('locale.languages')) > 1)
        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownLanguageLink" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">@lang('menus.language-picker.language') ({{ strtoupper(app()->getLocale()) }})</a>

            @include('includes.partials.lang')
        </li>
    @endif --}}

    @auth
      <li>
        <v-btn
          text
          dark
          href="{{route('frontend.user.dashboard')}}" 
          class="tc-main-menu-link {{ active_class(Active::checkRoute('frontend.user.dashboard')) }}"
        >
          <v-icon class="mr-2">
            dashboard
          </v-icon>
          @lang('navs.frontend.dashboard')
        </v-btn>
      </li>
    @endauth

    @guest
      <li>
        <v-btn 
          text
          dark
          href="{{route('frontend.auth.login')}}" 
          class="{{ active_class(Active::checkRoute('frontend.auth.login')) }}"
        >
          @lang('navs.frontend.login')
        </v-btn>
      </li>

        @if(config('access.registration'))
          <li>
            <v-btn 
              text
              dark
              href="{{route('frontend.auth.register')}}" 
              class="nav-link {{ active_class(Active::checkRoute('frontend.auth.register')) }}"
            >
              @lang('navs.frontend.register')
            </v-btn>
          </li>
        @endif
    @else
        @can('administer-tours')
          <li>
          <v-menu
            close-on-click
            close-on-content-click
            internal-activator
            offset-y
          >
            <template v-slot:activator="{ on }">
              <v-btn
                dark
                text
                v-on="on"
              >
                <v-icon class="mr-2">
                  work_outline
                </v-icon>
                @lang('labels.frontend.tours.management')
              </v-btn>
            </template>
            <v-list>
              <v-list-item class="pa-0">
                <v-list-item-title>
                  <a 
                    href="{{ route('frontend.tour.order.index') }}" 
                    class="tc-main-menu-dropdown-item {{ active_class(Active::checkRoute('frontend.tour.order.index')) }}"
                  >
                    @lang('labels.frontend.tours.order.management')
                  </a>
                </v-list-item-title>
              </v-list-item>

              <v-list-item class="pa-0">
                <v-list-item-title>
                  <a 
                    href="{{ route('frontend.tour.tour.index') }}" 
                    class="tc-main-menu-dropdown-item {{ active_class(Active::checkRoute('frontend.tour.tour.index')) }}"
                  >
                    @lang('labels.frontend.tours.tour.management')
                  </a>
                </v-list-item-title>
              </v-list-item>

              <v-list-item class="pa-0">
                <v-list-item-title>
                  <a 
                    href="{{ route('frontend.tour.type.index') }}" 
                    class="tc-main-menu-dropdown-item {{ active_class(Active::checkRoute('frontend.tour.type.index')) }}"
                  >
                    @lang('labels.frontend.tours.type.management')
                  </a>
                </v-list-item-title>
              </v-list-item>
              
              <v-list-item class="pa-0">
                <v-list-item-title>
                  <a 
                    href="{{ route('frontend.tour.customer-type.index') }}" 
                    class="tc-main-menu-dropdown-item {{ active_class(Active::checkRoute('frontend.tour.customer-type.index')) }}"
                  >
                    @lang('labels.frontend.tours.customer.type.management')
                  </a>
                </v-list-item-title>
              </v-list-item>

              <v-list-item class="pa-0">
                <v-list-item-title>
                  <a 
                    href="{{ route('frontend.tour.hotel-category.index') }}" 
                    class="tc-main-menu-dropdown-item {{ active_class(Active::checkRoute('frontend.tour.hotel-category.index')) }}"
                  >
                    @lang('labels.frontend.tours.hotel.category.management')
                  </a>
                </v-list-item-title>
              </v-list-item>
              
              <v-list-item class="pa-0">
                <v-list-item-title>
                  <a 
                    href="{{ route('frontend.tour.country.index') }}"
                    class="tc-main-menu-dropdown-item {{ active_class(Active::checkRoute('frontend.tour.country.index')) }}"
                  >
                    @lang('labels.frontend.tours.country.management') / @lang('labels.frontend.tours.city.management')
                  </a>
                </v-list-item-title>
              </v-list-item>

              <v-list-item class="pa-0">
                <v-list-item-title>
                  <a 
                    href="{{ route('frontend.tour.hotel.index') }}" 
                    class="tc-main-menu-dropdown-item {{ active_class(Active::checkRoute('frontend.tour.hotel.index')) }}"
                  >
                    @lang('labels.frontend.tours.hotel.management')
                  </a>
                </v-list-item-title>
              </v-list-item>
            
              <v-list-item class="pa-0">
                <v-list-item-title>
                  <a 
                    href="{{ route('frontend.tour.museum.index') }}"
                    class="tc-main-menu-dropdown-item {{ active_class(Active::checkRoute('frontend.tour.museum.index')) }}"
                  >
                    @lang('labels.frontend.tours.museum.management')
                  </a>
                </v-list-item-title>
              </v-list-item>
            
              <v-list-item class="pa-0">
                <v-list-item-title>
                  <a 
                    href="{{ route('frontend.tour.meal.index') }}" 
                    class="tc-main-menu-dropdown-item {{ active_class(Active::checkRoute('frontend.tour.meal.index')) }}"
                  >
                    @lang('labels.frontend.tours.meal.management')
                  </a>
                </v-list-item-title>
              </v-list-item>

              <v-list-item class="pa-0">
                <v-list-item-title>
                  <a 
                    href="{{ route('frontend.tour.transport.index') }}" 
                    class="tc-main-menu-dropdown-item {{ active_class(Active::checkRoute('frontend.tour.transport.index')) }}"
                  >
                    @lang('labels.frontend.tours.transport.management')
                  </a>
                </v-list-item-title>
              </v-list-item>
            
              <v-list-item class="pa-0">
                <v-list-item-title>
                  <a 
                    href="{{ route('frontend.tour.guide.index') }}" 
                    class="tc-main-menu-dropdown-item {{ active_class(Active::checkRoute('frontend.tour.guide.index')) }}"
                  >
                    @lang('labels.frontend.tours.guide.management')
                  </a>
                </v-list-item-title>
              </v-list-item>

              <v-list-item class="pa-0">
                <v-list-item-title>
                  <a 
                    href="{{ route('frontend.tour.attendant.index') }}" 
                    class="tc-main-menu-dropdown-item {{ active_class(Active::checkRoute('frontend.tour.attendant.index')) }}"
                  >
                    @lang('labels.frontend.tours.attendant.management')
                  </a>
                </v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
          </li>
        @endcan
        @can('administer-orders')
        <li>
          <v-menu offset-y>
            <template v-slot:activator="{ on }">
              <v-btn
                dark
                text
                v-on="on"
              >
                <v-icon class="mr-2">
                  work_outline
                </v-icon>
                @lang('labels.frontend.tours.management')
              </v-btn>
            </template>
            <v-list>
              <v-list-item class="pa-0">
                <v-list-item-title>
                  <a 
                    href="{{ route('frontend.agency.tour-list') }}" 
                    class="tc-main-menu-dropdown-item {{ active_class(Active::checkRoute('frontend.agency.tour-list')) }}"
                    >
                    @lang('labels.frontend.tours.tour.management')
                  </a>
                </v-list-item-title>
              </v-list-item>

              <v-list-item class="pa-0">
                <v-list-item-title>
                  <a 
                    href="{{ route('frontend.agency.order.index') }}" 
                    class="tc-main-menu-dropdown-item {{ active_class(Active::checkRoute('frontend.agency.order.index')) }}"
                  >
                    @lang('labels.frontend.tours.order.management')
                  </a>
                </v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </li>
        @endcan
        <li>
          <v-menu
            close-on-click
            close-on-content-click
            internal-activator
            offset-y
          >
            <template v-slot:activator="{ on }">
              <v-btn
                text
                text
                dark
                v-on="on"
              >
                <v-icon class="mr-2">
                  account_circle
                </v-icon>
                  {{ $logged_in_user->name }}
                <v-icon>
                  expand_more
                </v-icon>
              </v-btn>
            </template>
            <v-list>
              @can('view backend')
              <v-list-item class="pa-0">
                <v-list-item-title>
                  <a 
                    href="{{ route('admin.dashboard') }}" 
                    class="tc-main-menu-dropdown-item"
                  >
                    @lang('navs.frontend.user.administration')
                </a>
                </v-list-item-title>
              </v-list-item>
              @endcan

              @if($logged_in_user->isTeamOwner())
              <v-list-item class="pa-0">
                <v-list-item-title>
                  <a 
                    href="{{ route('frontend.user.team') }}" 
                    class="tc-main-menu-dropdown-item {{ active_class(Active::checkRoute('frontend.user.team')) }}"
                  >
                    @lang('navs.frontend.user.team')
                  </a>
                </v-list-item-title>
              </v-list-item>
              @endif

              <v-list-item class="pa-0">
                <v-list-item-title>
                  <a 
                    href="{{ route('frontend.user.account') }}" 
                    class="tc-main-menu-dropdown-item {{ active_class(Active::checkRoute('frontend.user.account')) }}"
                  >
                    @lang('navs.frontend.user.account')
                  </a>
                </v-list-item-title>
              </v-list-item>
              <v-list-item class="pa-0">
                <v-list-item-title>
                  <a 
                    href="{{ route('frontend.auth.logout') }}" 
                    class="tc-main-menu-dropdown-item"
                  >
                    @lang('navs.general.logout')
                  </a>
                </v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </li>
    @endguest

    <li>
      <v-btn 
        text
        dark
        href="{{route('frontend.contact')}}" 
        class="tc-main-menu-link {{ active_class(Active::checkRoute('frontend.contact')) }}"
      >
        <v-icon class="mr-2">
          help_outline
        </v-icon>
        <v-icon>
          expand_more
        </v-icon>
      </v-btn>
    </li>
  </ul>
  <v-btn 
    id="tc-main-menu-burger"
    text
    dark
    class="d-lg-none"
  >
    <v-icon>mdi-format-list-bulleted-square</v-icon>
  </v-btn>
</v-toolbar>
