@extends('frontend.layouts.app')

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col col-sm-8 align-self-center">

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title mb-0">
                                @lang('labels.frontend.tours.order.create')
                            </h5>
                        </div><!--col-->
                    </div><!--row-->

                    <hr>

                    @can('administer-orders')
                        @include('frontend.tour.agency.order.create-form')
                    @endcan

                </div><!--card-body-->
            </div><!--card-->

        </div><!-- col-md-8 -->
    </div><!-- row -->
@endsection
