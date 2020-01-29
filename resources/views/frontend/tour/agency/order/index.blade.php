@extends('frontend.layouts.app')
@push('scripts')
{!! script(mix('js/frontend_agency.js')) !!}
@endpush
@section('content')
<div id="agency-wrap"></div>
    <?php $sitems = json_encode($items); ?>
    <?php $stour_name = json_encode($tour_names); ?>
    <?php $soperators = json_encode($operators); ?>
    <?php $sstatuses = json_encode($statuses); ?>
    <agency-orders-index
        data-app
        :items="{{ $sitems }}"
        :tour-names="{{ $stour_name }}"
        :operators="{{ $soperators }}"
        :statuses="{{ $sstatuses }}"
        header="@lang('labels.frontend.tours.order.management')"
        token="{{ csrf_token() }}"
    ></agency-orders-index>

    @include('frontend.tour.includes.pagination-row')

    @if($deleted->count() > 0)

        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="text-danger mb-0 mr-1"><i class="far fa-trash-alt"></i> @lang('labels.general.deleted')</h6>
                        </div>
                    </div><!--col-->
                </div><!--row-->

                <div class="row mt-4">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>@lang('labels.frontend.tours.order.table.status')</th>
                                    <th>@lang('labels.frontend.tours.order.table.operator')</th>
                                    <th>@lang('labels.frontend.tours.order.table.tour_name')</th>
                                    <th><div class="float-right">@lang('labels.general.actions')</div></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($deleted as $item)
                                    <tr>
                                        <td>
                                            @if (array_key_exists($item->status, $statuses))
                                                <span class="text-secondary {{ $statuses[$item->status] }}">@lang('labels.frontend.tours.order.statuses.'.$item->status)</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (array_key_exists($item->operator_id, $operators))
                                                <span class="text-secondary">{{ $operators[$item->operator_id] }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (array_key_exists($item->tour_id, $tour_names))
                                                <span class="text-secondary">{{$tour_names[$item->tour_id]}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                                                {!! $item->action_buttons !!}
                                            </div><!--float-right-->
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div><!--col-->
                </div><!--row-->

            </div><!--card-body-->
        </div><!--card-->

    @endif

@endsection