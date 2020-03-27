@extends('frontend.layouts.app')

@section('content')
<?php $sitems = json_encode($items); ?>
<?php $stour_name = json_encode($tour_names); ?>
<?php $soperators = json_encode($operators); ?>
<?php $sstatuses = json_encode($statuses); ?>
<v-container fluid grid-list-md text-xs-center>
  <h1 class="text-white text-center">
    @lang('labels.frontend.tours.order.management')
  </h1>

  @if(count($items)>0)
  <v-row class="justify-center">
    <v-col>
      <v-card>
        <table class="tc-order-table">
          <thead>
            <th>
              №
            </th>
            <th>
              @lang('labels.frontend.tours.order.table.tour_name')
            </th>
            <th>
              @lang('labels.frontend.tours.order.table.tourists_data')
            </th>
            <th>
              @lang('labels.frontend.tours.order.table.price')
            </th>
            <th>
              @lang('labels.frontend.tours.order.table.commission')
            </th>
            <th>
              @lang('labels.frontend.tours.order.table.operator')
            </th>
            <th>
              @lang('labels.frontend.tours.order.table.agency_status')
            </th>
            <th>
              @lang('labels.frontend.tours.order.table.operator_status')
            </th>
            <th>
              @lang('labels.general.actions')
            </th>
          </thead>
          <tbody>
            @foreach($items as $item)
            <tr>
              <td>
                {{ $item->id }}
              </td>
              <td>
                @if (array_key_exists($item->tour_id, $tour_names))
                <span>{{$tour_names[$item->tour_id]}}</span>
                @endif
              </td>
              <td>
                {{-- данные о туристах --}}
                Туристов: {{ count($item->profiles[0]->content) }}
              </td>
              <td>
                {{ $item->total_price }}
              </td>
              <td>
                {{ $item->commission }}
              </td>
              <td>
                @if (array_key_exists($item->operator_id, $operators))
                <span class="text-secondary">{{ $operators[$item->operator_id] }}</span>
                @endif
              </td>
              <td>
                {{-- статус агентства --}}
              </td>
              <td>
                @if (array_key_exists($item->status, $statuses))
                <span
                  class="{{ $statuses[$item->status] }}">@lang('labels.frontend.tours.order.statuses.'.$item->status)</span>
                @endif
              </td>
              <td>
                <div class="float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                  {!! $item->action_buttons !!}
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </v-card>
    </v-col>
  </v-row>
  @endif
</v-container>

@include('frontend.tour.includes.pagination-row')

@if($deleted->count() > 0)

<div class="card mb-4">
  <div class="card-body">
    <div class="row">
      <div class="col">
        <div class="d-flex justify-content-between align-items-center">
          <h6 class="text-danger mb-0 mr-1"><i class="far fa-trash-alt"></i> @lang('labels.general.deleted')</h6>
        </div>
      </div>
      <!--col-->
    </div>
    <!--row-->

    <div class="row mt-4">
      <div class="col">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>@lang('labels.frontend.tours.order.table.status')</th>
                <th>@lang('labels.frontend.tours.order.table.operator')</th>
                <th>@lang('labels.frontend.tours.order.table.tour_name')</th>
                <th>
                  <div class="float-right">@lang('labels.general.actions')</div>
                </th>
              </tr>
            </thead>
            <tbody>
              @foreach($deleted as $item)
              <tr>
                <td>
                  @if (array_key_exists($item->status, $statuses))
                  <span
                    class="text-secondary {{ $statuses[$item->status] }}">@lang('labels.frontend.tours.order.statuses.'.$item->status)</span>
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
                  </div>
                  <!--float-right-->
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <!--col-->
    </div>
    <!--row-->

  </div>
  <!--card-body-->
</div>
<!--card-->

@endif

@endsection