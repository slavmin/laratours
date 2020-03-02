@extends('frontend.layouts.app')

@section('content')
<detailed-tour token="{{ csrf_token() }}" tour-id="{{ $tour_id }}" method="{{ $method }}" route="{{ $route }}">
</detailed-tour>
@endsection