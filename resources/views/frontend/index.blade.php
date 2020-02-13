@extends('frontend.layouts.app')
@push('after-styles')
<style>
.v-content__wrap {
  background: url('/img/frontend/bg-mountain.jpg') 0 0 no-repeat;
  background-size: cover;
}
.v-content__wrap:before {
  display: block;
  content: '';
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0px;
  left: 0;
  background-image: linear-gradient(to top, #000, rgba(0, 0, 0, 0.1));
  opacity: 0.4;
}
</style>
@endpush
@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('content')
<v-container class="d-flex justify-center align-center" style="height: 100%; margin-top: -64px;">
    <h1 class="white--text display-3" style="z-index: 3;">
      <v-row justify="center">
        <img src="/img/frontend/round-logo.png" width="120"></img>
      </v-row>
      TourClick
    </h1>
</v-container>
@endsection
