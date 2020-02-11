@extends('frontend.layouts.app')

@section('content')
    <div class="container-xl pt-4 mb-5">
        @include('frontend.tour.type.includes.header')
        <div class="row justify-content-center">
            <div class="col col-sm-8 align-self-center">

                <div class="card">
                    <img 
                        class="card-img-top" 
                        src="/img/frontend/reference/tour_types.jpg" 
                        alt="@lang('labels.frontend.tours.type.management')"
                    >
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title mb-0">
                                    @lang('labels.frontend.tours.type.create')
                                </h5>
                            </div><!--col-->
                        </div><!--row-->

                        <hr>

                        @include('frontend.tour.includes.'.$model_alias.'-form')

                    </div><!--card-body-->
                </div><!--card-->

            </div><!-- col-md-8 -->
        </div><!-- row -->
    </div>
@endsection
