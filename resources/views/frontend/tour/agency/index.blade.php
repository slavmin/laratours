@extends('frontend.layouts.app')

@section('content')
    
    <!-- Vue component -->
    @if(count($items)>0)
        <?php $sitems = json_encode($items); ?>
        <?php $scities = json_encode($cities_names); ?>
        <agency-tours-index
            data-app
            :items="{{ $sitems }}"
            :cities="{{ $scities }}"
            token="{{ csrf_token() }}"
        ></agency-tours-index>
    @endif
    <!-- /Vue component -->
    @include('frontend.tour.includes.pagination-row')
    @include('frontend.tour.includes.agency-select-form')


@endsection