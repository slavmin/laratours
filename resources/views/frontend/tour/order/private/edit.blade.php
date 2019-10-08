@extends('frontend.layouts.app')

@section('content')
    <!-- Vue component -->
    @can('administer-tours')
        <?php $sitems = json_encode($audits); ?>
        <?php $sitem = json_encode($item); ?>   
        <?php $stour = json_encode($tour); ?>  
        <?php $sstatuses = json_encode(app('translator')->getFromJson('labels.frontend.tours.order.statuses')); ?>
        <?php $sprofiles = json_encode($profiles); ?>
        <operator-order-edit
            data-app
            :tour="{{ $tour }}"
            :order="{{ $sitem }}"
            header-text="@lang('labels.frontend.tours.order.edit')"
            :statuses="{{ $sstatuses }}"
            :items="{{ $sitems }}"
            profiles-raw="{{ $sprofiles }}"
            token="{{ csrf_token() }}"
        ></operator-order-edit>
    @else
        <?php $sitems = json_encode($audits); ?>
        <?php $sitem = json_encode($item); ?>   
        <?php $sstatuses = json_encode(app('translator')->getFromJson('labels.frontend.tours.order.statuses')); ?>
        <?php $s_order_profiles = json_encode($profiles); ?>
        <?php $s_tour_profiles = json_encode($tour->orderprofiles); ?>  
        <?php $stour = json_encode($tour); ?>
        <agency-order-edit
            data-app
            :tour="{{ $stour }}"
            :order="{{ $sitem }}"
            header-text="@lang('labels.frontend.tours.order.edit')"
            :statuses="{{ $sstatuses }}"
            :items="{{ $sitems }}"
            profiles-raw="{{ $s_order_profiles }}"
            tour-profiles-raw="{{ $s_tour_profiles }}"
            token="{{ csrf_token() }}"
        ></agency-order-edit>
    @endcan
    <!-- /Vue component -->
    <div class="row justify-content-center align-items-center">
        <div class="col col-sm-8 align-self-center">

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
