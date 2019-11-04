@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.passwords.reset_password_box_title'))

@section('content')
    @if(session('status'))
        <messages
            messages="{{ session('status') }}"
            message-type="success"
        ></messages>
    @endif
    <reset-password
        data-app
        header-text="@lang('labels.frontend.passwords.reset_password_box_title')"
        reset-password-hint="@lang('labels.frontend.passwords.reset_password_hint')"
        reset-password-url="{{ route('frontend.auth.password.reset') }}"
        password-text="@lang('validation.attributes.frontend.password')"
        confirm-password-text="@lang('validation.attributes.frontend.password_confirmation')"
        submit-text="@lang('labels.frontend.passwords.reset_password_button')"
        user-token="{{ $token }}"
        user="{{ $email }}"
        token="{{ csrf_token() }}"
    ></reset-password>
@endsection
