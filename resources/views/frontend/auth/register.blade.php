@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.auth.register_box_title'))

@section('content')
{{-- {{dd($params)}} --}}
    @include('includes.partials.messages')
    <div class="my-5 row justify-content-center align-items-center">
        <div class="col col-sm-8 align-self-center">
            <div class="card">
                <div class="card-header white-text h2" style="background-color: rgb(102, 165, 174);">
                    @lang('labels.frontend.auth.register_box_title') юр. лица
                </div><!--card-header-->

                <div class="card-body">
                    <div class="row justify-content-center grey-text">
                        <h2>Регистрация по ИНН</h2>
                    </div>
                    {{ html()->form('GET', route('frontend.auth.register.get-data-by-inn'))->open() }}
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
                            {{ html()->label('Введите ИНН')->for('inn') }}

                                {{ html()->text('inn')
                                    ->class('form-control')
                                    ->id('inn')
                                    ->attribute('maxlength', 191)
                                    ->value($params['inn'] ?? '')
                                    ->required() }}
                            </div><!--form-group-->
                        </div><!--col-->
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-0 clearfix">
                                {{ form_submit('Заполнить')
                                    ->style("background-color: #aa282a !important;") }}
                            </div><!--form-group-->
                        </div><!--col-->
                    {{ html()->form()->close() }}
                    </div><!--row-->
                    <hr>
                    {{ html()->form('POST', route('frontend.auth.register.post'))->open() }}
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
                                {{ html()->label(__('validation.attributes.frontend.company.name'))->for('company_name') }}

                                {{ html()->text('profile[formal][company_name]')
                                    ->class('form-control')
                                    ->id('company_name')
                                    ->attribute('maxlength', 191)
                                    ->value($info['company_name'] ?? '')
                                    ->required() }}
                            </div><!--form-group-->
                        </div><!--col-->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.company.company_type'))
                                    ->class('grey-text')
                                    ->for('company_type') }}
                                {{ html()
                                    ->select('company_type')
                                    ->id('company_type')
                                    ->options(__('validation.attributes.frontend.company.company_types'))
                                    ->class('form-control') }}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div>
                    
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
                                {{ html()->label(__('validation.attributes.frontend.company.country'))->for('company_country') }}

                                {{ html()->text('profile[formal][company_country]')
                                    ->class('form-control')
                                    ->id('company_country')
                                    ->attribute('maxlength', 191)
                                    ->value($info['company_country'] ?? '')
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--row-->

                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
                                {{ html()->label(__('validation.attributes.frontend.company.city'))->for('company_city') }}

                                {{ html()->text('profile[formal][company_city]')
                                    ->class('form-control')
                                    ->id('company_city')->attribute('maxlength', 191)
                                    ->value($info['company_city'] ?? '')
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col">
                            <div class="form-group md-form">
                                {{ html()->label(__('validation.attributes.frontend.company.address'))->for('company_address') }}

                                {{ html()->text('profile[formal][company_address]')
                                    ->class('form-control')
                                    ->id('company_address')
                                    ->attribute('maxlength', 191)
                                    ->value($info['company_address'] ?? '')
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row--> 

                    <div class="row">
                        <div class="col">
                            <div class="form-group md-form">
                                {{ html()->label('ФИО генерального директора')->for('company_ceo_name') }}

                                {{ html()->text('profile[formal][company_ceo_name]')
                                    ->class('form-control')
                                    ->id('company_ceo_name')
                                    ->attribute('maxlength', 191)
                                    ->value($info['company_ceo_name'] ?? '')
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row--> 

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
                                {{ html()->label(__('validation.attributes.frontend.company.inn'))->for('company_inn') }}

                                {{ html()->text('profile[formal][company_inn]')
                                    ->class('form-control')
                                    ->id('company_inn')->attribute('maxlength', 191)
                                    ->value($info['company_inn'] ?? '')
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--row-->

                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
                                {{ html()->label(__('validation.attributes.frontend.company.kpp'))->for('company_kpp') }}

                                {{ html()->text('profile[formal][company_kpp]')
                                    ->class('form-control')
                                    ->id('company_kpp')->attribute('maxlength', 191)
                                    ->value($info['company_kpp'] ?? '')
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
                                {{ html()->label(__('validation.attributes.frontend.company.ogrn'))->for('ogrn') }}

                                {{ html()->text('profile[formal][company_ogrn]')
                                    ->class('form-control')
                                    ->id('company_ogrn')->attribute('maxlength', 191)
                                    ->value($info['company_ogrn'] ?? '')
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--row-->

                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
                                {{ html()->label(__('validation.attributes.frontend.company.okved'))->for('company_okved') }}

                                {{ html()->text('profile[formal][company_okved]')
                                    ->class('form-control')
                                    ->id('company_okved')
                                    ->attribute('maxlength', 191)
                                    ->value($info['company_okved'] ?? '')
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
                                {{ html()->label(__('validation.attributes.frontend.company.bik'))->for('bik') }}

                                {{ html()->text('profile[formal][company_bik]')
                                    ->class('form-control')
                                    ->id('company_bik')->attribute('maxlength', 191)
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--col-->

                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
                                {{ html()->label(__('validation.attributes.frontend.company.email').' организации')->for('company_email') }}

                                {{ html()->text('profile[formal][company_email]')
                                    ->class('form-control')
                                    ->id('company_email')->attribute('maxlength', 191)
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
                                {{ html()->label('Полное наименование банка')->for('company_bankname') }}

                                {{ html()->text('profile[formal][company_bankname]')
                                    ->class('form-control')
                                    ->id('company_bankname')->attribute('maxlength', 191)
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--col-->
                        
                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
                                {{ html()->label('Расчетный счёт')->for('company_bankaccount') }}

                                {{ html()->text('profile[formal][company_bankaccount]')
                                    ->class('form-control')
                                    ->id('company_bankaccount')->attribute('maxlength', 191)
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
                                {{ html()->label('Корреспондентский счет банка')->for('company_bankcorr') }}

                                {{ html()->text('profile[formal][company_bankcorr]')
                                    ->class('form-control')
                                    ->id('company_bankcorr')->attribute('maxlength', 191)
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--col-->
                        
                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
                                {{ html()->label('КПП банка')->for('company_bankkpp') }}

                                {{ html()->text('profile[formal][company_bankkpp]')
                                    ->class('form-control')
                                    ->id('company_bankkpp')->attribute('maxlength', 191)
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
                                {{ html()->label(__('validation.attributes.frontend.first_name'))->for('first_name') }}

                                {{ html()->text('first_name')
                                    ->class('form-control')->attribute('maxlength', 191)
                                    ->required()}}
                            </div><!--col-->
                        </div><!--row-->

                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
                                {{ html()->label(__('validation.attributes.frontend.last_name'))->for('last_name') }}

                                {{ html()->text('last_name')
                                    ->class('form-control')->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
                                {{ html()->label(__('validation.attributes.frontend.company.phone'))->for('company_phone') }}

                                {{ html()->text('profile[formal][company_phone]')
                                    ->class('form-control')
                                    ->id('company_phone')
                                    ->attribute('maxlength', 191)
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--row-->

                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
                                {{ html()->label(__('validation.attributes.frontend.company.email').' будет использоваться как логин')->for('email') }}

                                {{ html()->email('email')
                                    ->class('form-control')
                                    ->id('email')
                                    ->attribute('maxlength', 191)
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col">
                            <div class="form-group md-form">
                                {{ html()->label(__('validation.attributes.frontend.password'))->for('password') }}

                                {{ html()->password('password')
                                    ->class('form-control')->required() }}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col">
                            <div class="form-group md-form">
                                {{ html()->label(__('validation.attributes.frontend.password_confirmation'))->for('password_confirmation') }}

                                {{ html()->password('password_confirmation')
                                    ->class('form-control')
                                    ->required() }}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    @if(config('access.captcha.registration'))
                        <div class="row">
                            <div class="col">
                                @captcha
                                {{ html()->hidden('captcha_status', 'true') }}
                            </div><!--col-->
                        </div><!--row-->
                    @endif

                    <div class="row">
                        <div class="col">
                            <div class="form-group mb-0 clearfix">
                                {{ form_submit(__('labels.frontend.auth.register_button'))
                                    ->style("background-color: #aa282a !important;") }}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->
                    {{ html()->form()->close() }}

                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                                {!! $socialiteLinks !!}
                            </div>
                        </div><!--/ .col -->
                    </div><!-- / .row -->

                </div><!-- card-body -->
            </div><!-- card -->
        </div><!-- col-md-8 -->
    </div><!-- row -->
    {{-- <register-index
        data-app
        token="{{ csrf_token() }}"
    ></register-index> --}}
@endsection

@push('after-scripts')
    @if(config('access.captcha.registration'))
        @captchaScripts
    @endif
@endpush
