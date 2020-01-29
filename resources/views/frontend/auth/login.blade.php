@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.auth.login_box_title'))

@section('fullscreen-bg')
    <login
        data-app
        header-text="@lang('labels.frontend.auth.login_box_title')"
        login-url="{{ route('frontend.auth.login.post') }}"
        email-text="@lang('validation.attributes.frontend.email')"
        password-text="@lang('validation.attributes.frontend.password')"
        remember-text="@lang('labels.frontend.auth.remember_me')"
        submit-text="@lang('labels.frontend.auth.login_button')"
        password-reset-url="{{ route('frontend.auth.password.reset') }}"
        password-reset-text="@lang('labels.frontend.passwords.forgot_password')"
        token="{{ csrf_token() }}"
    ></login>
@endsection

