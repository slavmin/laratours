@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.passwords.reset_password_box_title'))

@section('content')
    @if(session('status'))
        <messages
            messages="{{ session('status') }}"
            message-type="success"
        ></messages>
    @endif
    <reset-email
        data-app
        header-text="@lang('labels.frontend.passwords.reset_password_box_title')"
        reset-password-url="{{ route('frontend.auth.password.email.post') }}"
        email-text="@lang('validation.attributes.frontend.email')"
        submit-text="@lang('labels.frontend.passwords.send_password_reset_link_button')"
        token="{{ csrf_token() }}"
    ></reset-email>
@endsection
