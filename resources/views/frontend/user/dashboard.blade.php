@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.dashboard') )

@section('content') 
<dashboard
    data-app
    team="{{ $team }}"
    header-text="@lang('navs.frontend.dashboard')"
    user-name="{{ $logged_in_user->name }}"
    user-email="{{ $logged_in_user->email }}"
    joined-text="@lang('strings.frontend.general.joined')"
    joined-time="{{ $logged_in_user->created_at }}"
    account-url="{{ route('frontend.user.account')}}"
    account-text="@lang('navs.frontend.user.account')"
    account-img-url="{{ $logged_in_user->picture }}"
    show-fill-demo="{{ $show_fill_demo }}"
></dashboard>
    
@endsection
