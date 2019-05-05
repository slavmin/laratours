@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.auth.register_box_title'))

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col col-sm-8 align-self-center">
            <div class="card">
                <div class="card-header">
                    <strong>
                        @lang('labels.frontend.auth.register_box_title')
                    </strong>
                </div><!--card-header-->

                <div class="card-body">
                    {{ html()->form('POST', route('frontend.auth.register.post'))->open() }}

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.company.name'))->for('company_name') }}

                                {{ html()->text('profile[formal][company_name]')
                                    ->class('form-control')
                                    ->id('company_name')
                                    ->placeholder(__('validation.attributes.frontend.company.name'))
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.company.phone'))->for('company_phone') }}

                                {{ html()->text('profile[formal][company_phone]')
                                    ->class('form-control')
                                    ->id('company_phone')
                                    ->placeholder(__('validation.attributes.frontend.company.phone'))
                                    ->attribute('maxlength', 191) }}
                            </div><!--form-group-->
                        </div><!--row-->

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.company.email'))->for('company_email') }}

                                {{ html()->email('profile[formal][company_email]')
                                    ->class('form-control')
                                    ->id('company_email')
                                    ->placeholder(__('validation.attributes.frontend.company.email'))
                                    ->attribute('maxlength', 191) }}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.company.country'))->for('company_country') }}

                                {{ html()->text('profile[formal][company_country]')
                                    ->class('form-control')
                                    ->id('company_country')
                                    ->placeholder(__('validation.attributes.frontend.company.country'))
                                    ->attribute('maxlength', 191) }}
                            </div><!--form-group-->
                        </div><!--row-->

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.company.city'))->for('company_city') }}

                                {{ html()->text('profile[formal][company_city]')
                                    ->class('form-control')
                                    ->id('company_city')
                                    ->placeholder(__('validation.attributes.frontend.company.city'))
                                    ->attribute('maxlength', 191) }}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.company.address'))->for('company_address') }}

                                {{ html()->text('profile[formal][company_address]')
                                    ->class('form-control')
                                    ->id('company_address')
                                    ->placeholder(__('validation.attributes.frontend.company.address'))
                                    ->attribute('maxlength', 191) }}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.company.inn'))->for('company_inn') }}

                                {{ html()->text('profile[formal][company_inn]')
                                    ->class('form-control')
                                    ->id('company_inn')
                                    ->placeholder(__('validation.attributes.frontend.company.inn'))
                                    ->attribute('maxlength', 191) }}
                            </div><!--form-group-->
                        </div><!--row-->

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.company.kpp'))->for('company_kpp') }}

                                {{ html()->text('profile[formal][company_kpp]')
                                    ->class('form-control')
                                    ->id('company_kpp')
                                    ->placeholder(__('validation.attributes.frontend.company.kpp'))
                                    ->attribute('maxlength', 191) }}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.first_name'))->for('first_name') }}

                                {{ html()->text('first_name')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.frontend.first_name'))
                                    ->attribute('maxlength', 191)
                                    ->required()}}
                            </div><!--col-->
                        </div><!--row-->

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.last_name'))->for('last_name') }}

                                {{ html()->text('last_name')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.frontend.last_name'))
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}

                                {{ html()->email('email')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.frontend.email'))
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.password'))->for('password') }}

                                {{ html()->password('password')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.frontend.password'))
                                    ->required() }}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.password_confirmation'))->for('password_confirmation') }}

                                {{ html()->password('password_confirmation')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.frontend.password_confirmation'))
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
                                {{ form_submit(__('labels.frontend.auth.register_button')) }}
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
@endsection

@push('after-scripts')
    @if(config('access.captcha.registration'))
        @captchaScripts
    @endif
@endpush
