@extends('frontend.layouts.app')

@section('content')
    <guide-index 
        data-app
        token="{{ csrf_token() }}"
    ></guide-index>

    @include('frontend.tour.includes.pagination-row')

    @include('frontend.tour.includes.trash-bin')

@endsection