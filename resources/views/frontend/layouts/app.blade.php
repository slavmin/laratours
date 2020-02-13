<!DOCTYPE html>
@langrtl
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
@else
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@endlangrtl
    <head>
        <meta charset="utf-8">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
        <link href="/css/loader.min.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
        <link rel="apple-touch-icon" sizes="57x57" href="/img/frontend/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/img/frontend/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/img/frontend/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/img/frontend/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/img/frontend/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/img/frontend/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/img/frontend/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/img/frontend/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/img/frontend/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="/img/frontend/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/img/frontend/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/img/frontend/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/img/frontend/favicon/favicon-16x16.png">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/img/frontend/favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        {{-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', app_name())</title>
        <meta name="description" content="@yield('meta_description', 'Laravel 5')">
        @yield('meta')

        {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
        @stack('before-styles')

        @yield('css')

        <!-- Check if the language is set to RTL, so apply the RTL layouts -->
        <!-- Otherwise apply the normal LTR layouts -->
        {{ style(mix('css/frontend.css')) }}

        <style>
            [v-cloak] > * { display:none; }
        </style>

        @stack('after-styles')
        @stack('scripts')

        <!-- Material Design Bootstrap -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap_mdb.css')}}">
        <link rel="stylesheet" href="{{ asset('css/mdb.css')}}">
        <script src="{{ asset('js/mdb.min.js') }}" defer></script>

        <!-- Vuetify -->
        <link rel="stylesheet" href="{{ asset('css/vuetify.min.css') }}">
        
    </head>
    <body>
        <div id="app" v-cloak>
          @include('includes.partials.logged-in-as')
          @include('includes.partials.messages')
            <v-app dark>
              <v-content class="tc-content-bg">
                @include('frontend.includes.nav')
                @yield('content')
              </v-content>
              <v-footer color="#A6D1D7">
                <v-layout row wrap align-center>
                  <v-flex xs12>
                    <div class="white--text ml-4">
                      © 2019-2020 Copyright: 
                      <a class="white--text" href="https://promo.tourclick.ru" target="_blank">
                        Tourclick
                      </a>
                    </div>
                  </v-flex>
                </v-layout>
              </v-footer>
            </v-app>
        </div><!-- #app -->
        @include('includes.partials.footer')
        @yield('contacts')

        <!-- Scripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
        @stack('before-scripts')
        {!! script(mix('js/manifest.js')) !!}
        {!! script(mix('js/vendor.js')) !!}
        {!! script(mix('js/frontend.js')) !!}
        
        @stack('after-scripts')


        <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>

        @include('includes.partials.ga')
    </body>
</html>
