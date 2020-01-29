@extends('frontend.layouts.app')
@push('scripts')
{!! script(mix('js/frontend_agency.js')) !!}
@endpush
@section('content')
<div id="agency-wrap"></div>
    <?php $stour = json_encode($tour); ?>
    <?php $sprofiles = json_encode($tour->orderprofiles); ?>
    <agency-order-tour
        data-app
        :tour="{{ $stour }}"
        profiles="{{ $sprofiles }}"
        header-text="@lang('labels.frontend.tours.order.create')"
        token="{{ csrf_token() }}"
    ></agency-order-tour> 
@endsection
