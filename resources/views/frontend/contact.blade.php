{{-- TO DO  --}}
{{-- Replace this page with normal templates!!! --}}
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
        @yield('meta')

        {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
        @stack('before-styles')

        <!-- Check if the language is set to RTL, so apply the RTL layouts -->
        <!-- Otherwise apply the normal LTR layouts -->
        {{ style(mix('css/frontend.css')) }}

        @stack('after-styles')
    </head>
    <body>
        <div id="app" style="height: 250px;">
            @include('includes.partials.logged-in-as')
            @include('frontend.includes.nav')
            @include('includes.partials.messages')
        </div>
        <div class="root-wrap">
            <div class="row justify-content-center">
                <div class="col col-sm-8 align-self-center">
                    <script id="bx24_form_inline" data-skip-moving="true">
                            (function(w,d,u,b){w['Bitrix24FormObject']=b;w[b] = w[b] || function(){arguments[0].ref=u;
                                    (w[b].forms=w[b].forms||[]).push(arguments[0])};
                                    if(w[b]['forms']) return;
                                    var s=d.createElement('script');s.async=1;s.src=u+'?'+(1*new Date());
                                    var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
                            })(window,document,'https://kovalenkosales.bitrix24.ru/bitrix/js/crm/form_loader.js','b24form');

                            b24form({"id":"9","lang":"ru","sec":"z1a6om","type":"inline"});
                    </script> 
                </div><!--col-->
            </div><!--row-->
            {{-- @include('includes.partials.footer') --}}
        </div><!-- root-wrap -->

        <!-- Scripts -->
        @stack('before-scripts')
        {!! script(mix('js/manifest.js')) !!}
        {!! script(mix('js/vendor.js')) !!}
        {!! script(mix('js/frontend.js')) !!}
        @stack('after-scripts')

        @include('includes.partials.ga')
    </body>
</html>

@push('after-scripts')
    @if(config('access.captcha.contact'))
        @captchaScripts
    @endif
@endpush