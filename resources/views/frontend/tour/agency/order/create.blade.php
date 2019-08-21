@extends('frontend.layouts.app')
<!-- @include('includes.partials.messages') -->

@section('content')
    <?php $sitem = json_encode($item); ?>
    <?php $sprofiles = json_encode($item->orderprofiles); ?>
    <agency-order-tour
        data-app
        :tour="{{ $sitem }}"
        profiles="{{ $sprofiles }}"
        header-text="@lang('labels.frontend.tours.order.create')"
        token="{{ csrf_token() }}"
    ></agency-order-tour> 
@endsection
