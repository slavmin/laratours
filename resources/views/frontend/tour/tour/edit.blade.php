@extends('frontend.layouts.app')
@push('scripts')
{!! script(mix('js/frontend_tour_constructor.js')) !!}
@endpush
@section('content')
<div id="tour-constructor"></div>
<tour-edit
    data-app
    token="{{ csrf_token() }}"
    :tour="{{ $item }}"
></tour-edit>
@endsection
