@extends('frontend.layouts.app')

@section('content')
<detailed-tour token="{{ csrf_token() }}" tour-id="{{ $tour_id }}"></detailed-tour>
@endsection