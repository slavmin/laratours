@extends('frontend.layouts.app')

@section('content')
<partner-tour token="{{ csrf_token() }}" tour-id="{{ $tour_id }}" tour-commission="{{ $tour_commission }}"
  :tour-extra={{ json_encode($tour_extra) }}></partner-tour>
@endsection