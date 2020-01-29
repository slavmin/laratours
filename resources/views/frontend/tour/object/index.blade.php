@extends('frontend.layouts.app')

@section('content')
    <h1 class="text-white text-center">
        @lang('labels.frontend.tours.'.$model_alias.'.management')
    </h1>
    @include('frontend.tour.includes.city-select-form')
    @include('frontend.tour.includes.pagination-row')

    {{-- <div class="container-xl">
        <div class="row">
            @foreach ($items as $item)
                <div class="col-lg-6 col-xs-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title">
                                {{ $item->name }}
                                <div class="float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                                    {!! $item->action_buttons !!}
                                </div>
                            </div>
                            <div class="card-text">
                                <p>{{ $cities_for_filter[$item->city_id] }}</p>
                                <table class="table">
                                    <thead>
                                        <th>Название</th>
                                        <th>Цены</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($item->objectables as $obj)
                                            <tr>
                                                <td>{{ $obj->name }}</td>
                                            </tr>
                                            <tr>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div> --}}
    
    <?php $scities = json_encode($cities_select); ?>
    @if ($model_alias == 'transport')
        <?php $sitems = json_encode($items); ?>
        <transport-index 
            :items="{{ $sitems }}"
            :cities="{{ $scities }}" 
            data-app
            token="{{ csrf_token() }}"
        ></transport-index>
    @endif
    @if ($model_alias == 'museum')
    <?php $sitems = json_encode($items); ?>
    <?php $scustomers = json_encode($customer_type_options_arrays); ?>
        <museum-index 
            data-app
            :items="{{ $sitems }}"
            :cities="{{ $scities }}" 
            :customers="{{ $scustomers }}"
            token="{{ csrf_token() }}"
        ></museum-index>
    @endif
    @if ($model_alias == 'hotel')
    <?php $sitems = json_encode($items); ?>
    <?php $scustomers = json_encode($customer_type_options); ?>
        <hotel-index 
            data-app
            :items="{{ $sitems }}"
            :customers="{{ $scustomers }}"
            token="{{ csrf_token() }}"
        ></hotel-index>
    @endif
    @if ($model_alias == 'meal')
    <?php $sitems = json_encode($items); ?>
        <meal-index 
            :items="{{ $sitems }}"
            data-app
            token="{{ csrf_token() }}"
        ></meal-index>
    @endif

    @include('frontend.tour.includes.trash-bin')

@endsection