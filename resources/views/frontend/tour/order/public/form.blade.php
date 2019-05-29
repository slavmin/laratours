@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.contact.box_title'))

@section('content')
    <div class="row justify-content-center">
        <div class="col col-sm-8 align-self-center">
            <div class="card">
                <div class="card-header">
                    <strong>
                        @lang('labels.frontend.tours.order.name')
                    </strong>
                </div><!--card-header-->

                <div class="card-body">
                    {{ html()->form('POST', route('frontend.guest.order.store'))->open() }}

                    {{--{{ html()->hidden('tour_id')->value($tour_id??0) }}
                    {{ html()->hidden('operator_id')->value($operator_id??0) }}--}}

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                {{ html()->label(__('labels.frontend.tours.order.table.tour_id'))->for('tour_id') }}

                                {{ html()->text('tour_id')
                                    ->class('form-control')
                                    ->id('tour_id')
                                    ->placeholder(__('labels.frontend.tours.order.table.tour_id'))
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.customer.first_name'))->for('first_name') }}

                                {{ html()->text('customer[0][first_name]')
                                    ->class('form-control')
                                    ->id('first_name')
                                    ->placeholder(__('validation.attributes.frontend.customer.first_name'))
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.customer.last_name'))->for('last_name') }}

                                {{ html()->text('customer[0][last_name]')
                                    ->class('form-control')
                                    ->id('last_name')
                                    ->placeholder(__('validation.attributes.frontend.customer.last_name'))
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.customer.phone'))->for('phone') }}

                                {{ html()->text('customer[0][phone]')
                                    ->class('form-control')
                                    ->id('phone')
                                    ->placeholder(__('validation.custom.phone_format'))
                                    ->attribute('maxlength', 191)
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--row-->

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.customer.email'))->for('email') }}

                                {{ html()->email('customer[0][email]')
                                    ->class('form-control')
                                    ->id('email')
                                    ->placeholder(__('validation.attributes.frontend.customer.email'))
                                    ->attribute('maxlength', 191)
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.customer.country'))->for('country') }}

                                {{ html()->text('customer[0][country]')
                                    ->class('form-control')
                                    ->id('country')
                                    ->placeholder(__('validation.attributes.frontend.customer.country'))
                                    ->attribute('maxlength', 191)
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--row-->

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.customer.city'))->for('city') }}

                                {{ html()->text('customer[0][city]')
                                    ->class('form-control')
                                    ->id('city')
                                    ->placeholder(__('validation.attributes.frontend.customer.city'))
                                    ->attribute('maxlength', 191)
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.customer.address'))->for('address') }}

                                {{ html()->text('customer[0][address]')
                                    ->class('form-control')
                                    ->id('address')
                                    ->placeholder(__('validation.attributes.frontend.customer.address'))
                                    ->attribute('maxlength', 191)
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->


                        @if(config('access.captcha.contact'))
                            <div class="row">
                                <div class="col">
                                    @captcha
                                    {{ html()->hidden('captcha_status', 'true') }}
                                </div><!--col-->
                            </div><!--row-->
                        @endif

                    <div class="row mt-4">
                        <div class="col">
                            <div class="form-group row">
                                <div class="col">
                                    {{ html()->a(route('frontend.index'), __('buttons.general.cancel'))->class('btn btn-outline-info btn-sm') }}
                                </div><!--col-->

                                <div class="col text-right">
                                    {{ html()->submit(__('labels.frontend.contact.button'))->class('btn btn-success btn-sm') }}
                                </div><!--col-->
                            </div><!--form-group-->

                        </div><!--col-->
                    </div><!--row-->

                    {{ html()->form()->close() }}
                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection

@push('after-scripts')
    @if(config('access.captcha.contact'))
        @captchaScripts
    @endif
@endpush