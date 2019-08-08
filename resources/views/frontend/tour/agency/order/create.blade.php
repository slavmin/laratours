@extends('frontend.layouts.app')

@section('content')
    <?php $sitem = json_encode($item); ?>
    <agency-order-tour
        data-app
        :tour="{{ $sitem }}"
        header-text="@lang('labels.frontend.tours.order.create')"
        token="{{ csrf_token() }}"
    ></agency-order-tour> 
@endsection
