@extends('frontend.layouts.app')

@section('content')
    <?php $sitems = json_encode($items); ?>
    <?php $sreq_params = json_encode($req_params); ?>
    <tour-index 
        data-app
        token="{{ csrf_token() }}"
        :items="{{ $sitems }}"
        :req-params="{{ $sreq_params }}"
    ></tour-index>

    {{-- @include('frontend.tour.includes.pagination-row') --}}
    @include('frontend.tour.includes.city-type-select-form')

    @include('frontend.tour.includes.trash-bin')

@endsection