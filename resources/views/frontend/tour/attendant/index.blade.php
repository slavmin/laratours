@extends('frontend.layouts.app')

@section('content')
    <attendant-index 
        data-app
        token="{{ csrf_token() }}"
    ></attendant-index>

    @include('frontend.tour.includes.pagination-row')

    @include('frontend.tour.includes.trash-bin')

@endsection