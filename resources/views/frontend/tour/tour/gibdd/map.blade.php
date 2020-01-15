@extends('frontend.layouts.app')
@push('scripts')
  <script src="https://api-maps.yandex.ru/2.1/?apikey=c239b0e4-e39a-439a-bffc-7530876a731f&lang=ru_RU"></script>
@endpush
@section('content')
  <?php $sstreets = json_encode($streets); ?>
  <yandex-map
    :streets="{{ $sstreets }}"
  ></yandex-map>
@endsection
