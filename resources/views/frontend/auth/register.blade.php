@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.auth.register_box_title'))
@push('after-scripts')
    <script src="/js/inputmask.js"></script>
    <script src="/js/inputmask.binding.js"></script>
@endpush
@section('content')
<<<<<<< HEAD
    <div class="my-5 row justify-content-center align-items-center">
        <div class="col col-sm-10 align-self-center">
            <div class="card">
                <div class="card-header white-text h2" style="background-color: rgb(102, 165, 174);">
                    @lang('labels.frontend.auth.register_box_title') юр. лица
                </div><!--card-header-->

                <div class="card-body">
                    <div class="row justify-content-center grey-text">
                        <h2>Введите ИНН и большинство полей заполнится автоматически</h2>
                    </div>
                    {{ html()->form('GET', route('frontend.auth.register.get-data-by-inn'))->open() }}
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
                            {{ html()->label('ИНН вашей организации')->for('inn') }}

                                {{ html()->text('inn')
                                    ->class('form-control')
                                    ->id('inn')
                                    ->attribute('maxlength', 191)
                                    ->attribute('data-inputmask', "'mask': '9999999999'")
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
                    <div class="row justify-content-center grey-text">
                        <h2>Название и реквизиты организации</h2>
                    </div>
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
                                <?php $types_array = (__('validation.attributes.frontend.company.company_types')); ?>
                                <select
                                    name="profile[formal][company_type]"
                                    id="company_type"
                                    class="form-control"
                                    placeholder=""
                                    required
                                >
                                    @foreach ($types_array as $type)
                                        <option
                                            value="{{$type}}"
                                        >
                                            {{$type}}
                                        </option>
                                    @endforeach
                                </select>
                            </div><!--form-group-->
                        </div><!--col-->
                    </div>
                    
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
=======
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
                                    ->placeholder(__('validation.custom.phone_format'))
                                    ->attribute('maxlength', 191)
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--row-->

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.company.email'))->for('company_email') }}

                                {{ html()->email('profile[formal][company_email]')
                                    ->class('form-control')
                                    ->id('company_email')
                                    ->placeholder(__('validation.attributes.frontend.company.email'))
                                    ->attribute('maxlength', 191)
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
>>>>>>> dropjs
                                {{ html()->label(__('validation.attributes.frontend.company.country'))->for('company_country') }}

                                {{ html()->text('profile[formal][company_country]')
                                    ->class('form-control')
                                    ->id('company_country')
<<<<<<< HEAD
                                    ->attribute('maxlength', 191)
                                    ->value($info['company_country'] ?? '')
=======
                                    ->placeholder(__('validation.attributes.frontend.company.country'))
                                    ->attribute('maxlength', 191)
>>>>>>> dropjs
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--row-->

                        <div class="col-12 col-md-6">
<<<<<<< HEAD
                            <div class="form-group md-form">
=======
                            <div class="form-group">
>>>>>>> dropjs
                                {{ html()->label(__('validation.attributes.frontend.company.city'))->for('company_city') }}

                                {{ html()->text('profile[formal][company_city]')
                                    ->class('form-control')
<<<<<<< HEAD
                                    ->id('company_city')->attribute('maxlength', 191)
                                    ->value($info['company_city'] ?? '')
=======
                                    ->id('company_city')
                                    ->placeholder(__('validation.attributes.frontend.company.city'))
                                    ->attribute('maxlength', 191)
>>>>>>> dropjs
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col">
<<<<<<< HEAD
                            <div class="form-group md-form">
=======
                            <div class="form-group">
>>>>>>> dropjs
                                {{ html()->label(__('validation.attributes.frontend.company.address'))->for('company_address') }}

                                {{ html()->text('profile[formal][company_address]')
                                    ->class('form-control')
                                    ->id('company_address')
<<<<<<< HEAD
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
=======
                                    ->placeholder(__('validation.attributes.frontend.company.address'))
                                    ->attribute('maxlength', 191)
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
>>>>>>> dropjs
                                {{ html()->label(__('validation.attributes.frontend.company.inn'))->for('company_inn') }}

                                {{ html()->text('profile[formal][company_inn]')
                                    ->class('form-control')
<<<<<<< HEAD
                                    ->id('company_inn')->attribute('maxlength', 191)
                                    ->value($info['company_inn'] ?? '')
                                    ->attribute('data-inputmask', "'mask': '9999999999'")
=======
                                    ->id('company_inn')
                                    ->placeholder(__('validation.attributes.frontend.company.inn'))
                                    ->attribute('maxlength', 191)
>>>>>>> dropjs
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--row-->

                        <div class="col-12 col-md-6">
<<<<<<< HEAD
                            <div class="form-group md-form">
=======
                            <div class="form-group">
>>>>>>> dropjs
                                {{ html()->label(__('validation.attributes.frontend.company.kpp'))->for('company_kpp') }}

                                {{ html()->text('profile[formal][company_kpp]')
                                    ->class('form-control')
<<<<<<< HEAD
                                    ->id('company_kpp')->attribute('maxlength', 191)
                                    ->value($info['company_kpp'] ?? '')
                                    ->attribute('data-inputmask', "'mask': '999999999'")
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
                                    ->attribute('data-inputmask', "'mask': '9999999999'")
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
                                    ->attribute('data-inputmask', "'mask': '9999999999'")
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
                                    ->attribute('data-inputmask', "'mask': '99999999999999999999'")
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
                                    ->attribute('data-inputmask', "'mask': '99999999999999999999'")
=======
                                    ->id('company_kpp')
                                    ->placeholder(__('validation.attributes.frontend.company.kpp'))
                                    ->attribute('maxlength', 191)
>>>>>>> dropjs
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col-12 col-md-6">
<<<<<<< HEAD
                            <div class="form-group md-form">
                                {{ html()->label('Корреспондентский счет банка')->for('company_bankcorr') }}

                                {{ html()->text('profile[formal][company_bankcorr]')
                                    ->class('form-control')
                                    ->id('company_bankcorr')->attribute('maxlength', 191)
                                    ->attribute('data-inputmask', "'mask': '99999999999999999999'")
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--col-->
                        
                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
                                {{ html()->label('КПП банка')->for('company_bankkpp') }}

                                {{ html()->text('profile[formal][company_bankkpp]')
                                    ->class('form-control')
                                    ->id('company_bankkpp')->attribute('maxlength', 191)
                                    ->attribute('data-inputmask', "'mask': '999999999'")
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <hr>
                    <div class="row justify-content-center grey-text">
                        <h2>Контактные данные ответственного лица</h2>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
                                {{ html()->label(__('validation.attributes.frontend.first_name'))->for('first_name') }}

                                {{ html()->text('first_name')
                                    ->class('form-control')->attribute('maxlength', 191)
=======
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.first_name'))->for('first_name') }}

                                {{ html()->text('first_name')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.frontend.first_name'))
                                    ->attribute('maxlength', 191)
>>>>>>> dropjs
                                    ->required()}}
                            </div><!--col-->
                        </div><!--row-->

                        <div class="col-12 col-md-6">
<<<<<<< HEAD
                            <div class="form-group md-form">
                                {{ html()->label(__('validation.attributes.frontend.last_name'))->for('last_name') }}

                                {{ html()->text('last_name')
                                    ->class('form-control')->attribute('maxlength', 191)
=======
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.last_name'))->for('last_name') }}

                                {{ html()->text('last_name')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.frontend.last_name'))
                                    ->attribute('maxlength', 191)
>>>>>>> dropjs
                                    ->required() }}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
<<<<<<< HEAD
                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
                                {{ html()->label(__('validation.attributes.frontend.company.phone'))->for('company_phone') }}

                                {{ html()->text('profile[formal][company_phone]')
                                    ->class('form-control')
                                    ->id('company_phone')
                                    ->attribute('maxlength', 191)
                                    ->attribute('data-inputmask', "'mask': '[9-]999-999-99-99'")
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--row-->

                        <div class="col-12 col-md-6">
                            
                        </div><!--col-->
                    </div><!--row-->
                    <hr>
                    <div class="row justify-content-center">
                        <h2 class="grey-text">
                            Данные для входа в систему
                        </h2>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
                                {{ html()->label(__('validation.attributes.frontend.company.email').' (логин)')->for('email') }}

                                {{ html()->email('email')
                                    ->class('form-control')
                                    ->id('email')
                                    ->attribute('maxlength', 191)
                                    ->required()}}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
                                {{ html()->label(__('validation.attributes.frontend.password'))->for('password') }}

                                {{ html()->password('password')
                                    ->class('form-control')->required() }}
                            </div><!--form-group-->
                        </div><!--col-->

                        <div class="col-12 col-md-6">
                            <div class="form-group md-form">
=======
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
>>>>>>> dropjs
                                {{ html()->label(__('validation.attributes.frontend.password_confirmation'))->for('password_confirmation') }}

                                {{ html()->password('password_confirmation')
                                    ->class('form-control')
<<<<<<< HEAD
=======
                                    ->placeholder(__('validation.attributes.frontend.password_confirmation'))
>>>>>>> dropjs
                                    ->required() }}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

<<<<<<< HEAD
                    <div class="row justify-content-center">
                        <div class="grey-text">
                            Минимум 6 символов. Используйте латинские буквы и цифры.
                        </div>
                    </div>

=======
>>>>>>> dropjs
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
<<<<<<< HEAD
                                {{ form_submit(__('labels.frontend.auth.register_button'))
                                    ->style("background-color: #aa282a !important;") }}
=======
                                {{ form_submit(__('labels.frontend.auth.register_button')) }}
>>>>>>> dropjs
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
<<<<<<< HEAD
    {{-- <register-index
        data-app
        token="{{ csrf_token() }}"
    ></register-index> --}}
=======
>>>>>>> dropjs
@endsection

@push('after-scripts')
    @if(config('access.captcha.registration'))
        @captchaScripts
    @endif
@endpush
