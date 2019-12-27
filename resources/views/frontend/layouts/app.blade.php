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
        <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet">
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
    </head>
    <body>
        <div id="app">
            @include('includes.partials.logged-in-as')
            @include('frontend.includes.nav')
            @include('includes.partials.messages')

            <div class="root-wrap">
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

        {{-- <script type="text/javascript">
            snow_img = "/img/frontend/snow.gif";                                       
            snow_no = 10;   // quantity                                            
            var timeszimaon = 0;    // on/off                                          
            if (typeof(window.pageYOffset) == "number") {
            snow_browser_width = window.innerWidth;
            snow_browser_height = window.innerHeight; }
            else if (document.body && (document.body.scrollLeft || document.body.scrollTop)) {
            snow_browser_width = document.body.offsetWidth;
            snow_browser_height = document.body.offsetHeight; }
            else if (document.documentElement && (document.documentElement.scrollLeft || document.documentElement.scrollTop)) {
            snow_browser_width = document.documentElement.offsetWidth;
            snow_browser_height = document.documentElement.offsetHeight; }
            else {
            snow_browser_width = 500;
            snow_browser_height = 500; }
            snow_dx = [];
            snow_xp = [];
            snow_yp = [];
            snow_am = [];
            snow_stx = [];
            snow_sty = [];
            if (timeszimaon == 1) {
            for (i = 0; i < snow_no; i++) {
            snow_dx[i] = 0;
            snow_xp[i] = Math.random()*(snow_browser_width-50);
            snow_yp[i] = Math.random()*snow_browser_height;
            snow_am[i] = Math.random()*20;
            snow_stx[i] = 0.02 + Math.random()/10;
            snow_sty[i] = 0.7 + Math.random();
            
            if (i == 0) document.write("<\div id=\"snow_flake0\" style=\"position:absolute;z-index:0\"><a href=\"#\" target=\"_blank\"><\img src=\""+snow_img+"\" border=\"0\"></a><\/div>");
            else document.write("<\div id=\"snow_flake"+ i +"\" style=\"position:absolute;z-index:10000"+i+"\"><\img src=\""+snow_img+"\" border=\"0\"><\/div>");
            }
            }
            function SnowStart() {
            for (i = 0; i < snow_no; i++) {
            snow_yp[i] += snow_sty[i];
            if (snow_yp[i] > snow_browser_height-50) {
            snow_xp[i] = Math.random()*(snow_browser_width-snow_am[i]-30);
            snow_yp[i] = 0;
            snow_stx[i] = 0.02 + Math.random()/10;
            snow_sty[i] = 0.7 + Math.random();}
            snow_dx[i] += snow_stx[i];
            document.getElementById("snow_flake"+i).style.top=snow_yp[i]+"px";
            document.getElementById("snow_flake"+i).style.left=snow_xp[i] + snow_am[i]*Math.sin(snow_dx[i])+"px";}
            snow_time = setTimeout("SnowStart()", 10); }
            if (timeszimaon == 1) { SnowStart(); }
            </script> --}}

        @include('includes.partials.ga')
    </body>
</html>
