@extends('frontend.layouts.app')

@section('content')
    <!-- Vue component -->
        <!-- <?php $sitems = json_encode($audits); ?>
        <operator-order-edit
            data-app
            :items="{{ $sitems }}"
        ></operator-order-edit> -->
    <!-- /Vue component -->
    <div class="row justify-content-center align-items-center">
        <div class="col col-sm-8 align-self-center">

            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title mb-0">
                                @lang('labels.frontend.tours.order.edit')
                            </h5>
                        </div><!--col-->
                    </div><!--row-->

                    <hr>

                    @include('frontend.tour.order.private.form')

                </div><!--card-body-->
            </div><!--card-->


            @if($audits->count() > 0)
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-info">
                                    @lang('labels.frontend.tours.order.status')
                                </h5>
                            </div><!--col-->
                        </div><!--row-->

                        <div class="list-group list-group-flush">
                            @foreach($audits as $audit)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <div class="w-25">{{ timezone()->convertToLocal($audit->created_at) }}</div>
                                        <div class="w-auto">{{ $audit->user->name }}</div>
                                        <div class="w-25">
                                            @foreach($audit->new_values as $attribute => $value)
                                                @if (array_key_exists($item->status, $statuses))
                                                    <span class="{{ $statuses[$value] }}">@lang('labels.frontend.tours.order.statuses.'.$value)</span>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div><!--card-body-->
                </div><!--card-->
            @endif

        </div><!-- col-md-8 -->
    </div><!-- row -->
@endsection
