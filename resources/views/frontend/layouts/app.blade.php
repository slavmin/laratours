<!DOCTYPE html>
@langrtl
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
@else
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@endlangrtl
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>ТурКлик | tour-click.ru</title>
        <meta name="description" content="@yield('meta_description', 'Laravel 5')">
        <link href="https://fonts.googleapis.com/css?family=Merriweather&display=swap" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Roboto:100,200,300,400,500,700,900|Material+Icons' rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap&subset=cyrillic,cyrillic-ext" rel="stylesheet">
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
        @yield('meta')

        {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
        @stack('before-styles')

        <!-- Check if the language is set to RTL, so apply the RTL layouts -->
        <!-- Otherwise apply the normal LTR layouts -->
        {{ style(mix('css/frontend.css')) }}

        @stack('after-styles')
        @stack('scripts')

        <!-- Material Design Bootstrap -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap_mdb.css')}}">
        <link rel="stylesheet" href="{{ asset('css/mdb.css')}}">
        <script src="{{ asset('js/mdb.min.js') }}" defer></script>
        
    </head>
    <body>
        <div id="app">
            @include('includes.partials.logged-in-as')
            @include('frontend.includes.nav')
            @include('includes.partials.messages')

            <div class="root-wrap tc-blue-bg pt-4">
                @yield('content')
                @include('includes.partials.footer')
            </div><!-- root-wrap -->
        </div><!-- #app -->
        @yield('contacts')

        <!-- Scripts -->
        @stack('before-scripts')
        {!! script(mix('js/manifest.js')) !!}
        {!! script(mix('js/vendor.js')) !!}
        {!! script(mix('js/frontend.js')) !!}
        
        @stack('after-scripts')

        @include('includes.partials.ga')
    </body>
</html>
