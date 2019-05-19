@extends('frontend.layouts.app')

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col col-sm-8 align-self-center">

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <h5 class="card-title mb-0">
                                @lang('labels.frontend.tours.'.$model_alias.'.edit')
                            </h5>
                        </div><!--col-->
                    </div><!--row-->

                    <hr>

                    @include('frontend.tour.object.includes.'.$model_alias.'.form')

                </div><!--card-body-->

                {{--<div class="card-footer">
                    <div class="row">
                        <div class="col">

                        </div><!--col-->
                    </div><!--row-->
                </div><!--card-footer-->--}}

            </div><!--card-->


        </div><!-- col-md-8 -->
    </div><!-- row -->

    <div class="row justify-content-center align-items-center">
        <div class="col col-sm-8 align-self-center">

            {{--@if($item_attributes)--}}
                @foreach($attributes as $attribute)

                   @include('frontend.tour.object.includes.extra-form')

                @endforeach
            {{--@endif--}}

        </div><!-- col-md-8 -->
    </div><!-- row -->
@endsection
