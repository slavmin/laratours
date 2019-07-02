@extends('frontend.layouts.app')

@section('content')

    @include('frontend.tour.includes.city-select-form')

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="text-info mb-0 mr-1">@lang('labels.frontend.tours.'.$model_alias.'.management')</h6>
                        <!-- Modal Vue component. Пока только "Транспорт" -->
                        <?php $scities = json_encode($cities_select); ?>
                        <add-object-component 
                            type="@lang('labels.frontend.tours.'.$model_alias.'.management')"
                            field-name="@lang('validation.attributes.frontend.general.name')"
                            :fields="{
                                name: 'Название',
                                city: 'Город',
                                quantity: 'Количество',
                                description: 'Описание'
                            }"
                            :cities-select="{{ $scities }}"
                            token="{{ csrf_token() }}"
                        ></add-object-component>
                        <!-- /Modal Vue component. Пока только "Транспорт" -->
                        <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                            <a href="{{ route('frontend.tour.'.$model_alias.'.create', $city_param) }}" class="btn btn-success ml-1" data-toggle="tooltip" title="@lang('buttons.general.crud.create')">
                                <i class="fas fa-plus"></i>
                            </a>   
                        </div><!--btn-toolbar-->
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
                                <th>@lang('labels.frontend.tours.tour.city')</th>
                                <th>@lang('labels.frontend.tours.'.$model_alias.'.table.qnt')</th>
                                <th><div class="float-right">@lang('labels.general.actions')</div></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                    <tr>
                                        <td>{{$item->name}}</td>
                                        <td>
                                            @if (array_key_exists($item->city_id, $cities_names))
                                                <span class="text-secondary">{{$cities_names[$item->city_id]}}
                                                <!-- {{$item}} -->
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{$item->qnt}}</td>
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

    @include('frontend.tour.includes.trash-bin')

@endsection