@extends('frontend.layouts.app')

@section('content')

    <?php $scities = json_encode($cities_select); ?>
    @if ($model_alias == 'transport')
        <transport-index 
            :cities="{{ $scities }}" 
            data-app
            token="{{ csrf_token() }}"
        ></transport-index>
    @endif
    @if ($model_alias == 'museum')
    <?php $scustomers = json_encode($customer_type_options_arrays); ?>
        <museum-index 
            data-app
            :cities="{{ $scities }}" 
            :customers="{{ $scustomers }}"
            token="{{ csrf_token() }}"
        ></museum-index>
    @endif
    @if ($model_alias == 'hotel')
    <?php $scustomers = json_encode($customer_type_options); ?>
        <hotel-index 
            data-app
            :customers="{{ $scustomers }}"
            token="{{ csrf_token() }}"
        ></hotel-index>
    @endif
    @if ($model_alias == 'meal')
        <meal-index 
            data-app
            token="{{ csrf_token() }}"
        ></meal-index>
    @endif
    @include('frontend.tour.includes.pagination-row')
    @include('frontend.tour.includes.city-select-form')

    @include('frontend.tour.includes.trash-bin')

@endsection