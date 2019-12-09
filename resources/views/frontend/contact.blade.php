@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.contact.box_title'))

@section('contacts')
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
@endsection

@push('after-scripts')
    @if(config('access.captcha.contact'))
        @captchaScripts
    @endif
@endpush