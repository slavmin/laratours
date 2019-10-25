@extends('frontend.layouts.app')

@section('content')

    <?php $sitems = json_encode($items); ?>
    <tour-index 
        data-app
        token="{{ csrf_token() }}"
        :items="{{ $sitems }}"
    ></tour-index>

    {{-- @include('frontend.tour.includes.pagination-row') --}}
    @include('frontend.tour.includes.city-type-select-form')

    @include('frontend.tour.includes.trash-bin')

@endsection