@extends('frontend.layouts.app')
@push('scripts')
  <script src="https://api-maps.yandex.ru/2.1/?apikey=c239b0e4-e39a-439a-bffc-7530876a731f&lang=ru_RU"></script>
  {!! script(mix('js/frontend_tour_constructor.js')) !!}
@endpush
@section('content')
<div id="tour-constructor"></div>
  <?php $sstreets_by_days = json_encode($streets_by_days); ?>
  <tour-routes
    :data="{{ $sstreets_by_days }}"
  ></tour-routes>
@endsection
