@extends('frontend.layouts.app')

@section('content')

    @include('frontend.tour.includes.agency-select-form')
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
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="text-info mb-0 mr-1">@lang('labels.frontend.tours.'.$model_alias.'.management')</h6>
                    </div>
                </div><!--col-->
            </div><!--row-->

            @if(count($items)>0)
            <div class="row mt-4">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>@lang('labels.frontend.tours.'.$model_alias.'.table.name')</th>
                                <th>@lang('labels.frontend.tours.'.$model_alias.'.table.type')</th>
                                <th>@lang('labels.frontend.tours.tour.city')</th>
                                <th>@lang('labels.frontend.tours.'.$model_alias.'.table.duration')</th>
                                <th><div class="float-right">@lang('labels.general.actions')</div></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                    <tr>
                                        <td>{{$item->name}}</td>
                                        <td>
                                            @if (array_key_exists($item->tour_type_id, $tour_types))
                                                <span class="text-secondary">{{$tour_types[$item->tour_type_id]}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!is_null($item->cities_list))
                                                @foreach($item->cities_list as $city)
                                                    @if (array_key_exists($city, $cities_names))
                                                        <span class="text-secondary">{{$cities_names[$city]}}</span>
                                                    @endif
                                                @endforeach
                                            @else
                                                <span class="text-secondary">N/A</span>
                                            @endif
                                        </td>
                                        <td>{{$item->duration}}</td>
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
            @endif

        </div><!--card-body-->
    </div><!--card-->

    @include('frontend.tour.includes.pagination-row')

@endsection