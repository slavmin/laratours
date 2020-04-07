@extends('frontend.layouts.app')
@push('scripts')
<script src="https://api-maps.yandex.ru/2.1/?apikey=c239b0e4-e39a-439a-bffc-7530876a731f&lang=ru_RU"></script>
{{-- {!! script(mix('js/frontend_tour_constructor.js')) !!} --}}
@endpush
@section('content')
<?php $sstreets_by_days = json_encode($streets_by_days); ?>
<?php $stour_transport_days = json_encode($tour_transport_days); ?>
<?php $snotify_data = json_encode($notify_data); ?>
<tour-routes data-app :data="{{ $sstreets_by_days }}" :tour-transport-days="{{ $stour_transport_days }}"
    req-tour-day="{{ $req_tour_day }}" tour-id="{{ $tour_id }}" :notify-data="{{ $snotify_data }}"></tour-routes>
@endsection