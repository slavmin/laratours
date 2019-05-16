@extends('frontend.layouts.app')

@section('content')

    @include('frontend.tour.includes.city-select-form')

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="text-info mb-0 mr-1">@lang('labels.frontend.tours.meal.management')</h6>
                        <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                            <a href="{{ route('frontend.tour.meal.create', $city_param) }}" class="btn btn-success ml-1" data-toggle="tooltip" title="@lang('buttons.general.crud.create')">
                                <i class="fas fa-plus"></i></a>
                        </div><!--btn-toolbar-->
                    </div>
                </div><!--col-->
            </div><!--row-->

            <div class="row mt-4">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>@lang('labels.frontend.tours.meal.table.name')</th>
                                <th>@lang('labels.frontend.tours.tour.city')</th>
                                <th>@lang('labels.frontend.tours.meal.table.qnt')</th>
                                <th><div class="float-right">@lang('labels.general.actions')</div></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $sub_items)
                                @foreach($sub_items as $item)
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td>
                                        @if (array_key_exists($item->city_id, $cities_names))
                                            <span class="text-secondary">{{$cities_names[$item->city_id]}}</span>
                                        @endif
                                    </td>
                                    <td>{{$item->qnt}}</td>
                                    <td>
                                        <div class="float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                                            <a href="{{ route('frontend.tour.meal.edit', $item->id) }}" class="btn btn-outline-success ml-1" data-toggle="tooltip" title="@lang('labels.general.buttons.update')">
                                                <i class="fas fa-edit"></i></a>
                                            <form style="display: inline-block;" action="{{ route('frontend.tour.meal.destroy', $item->id) }}" method="post">
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="_method" value="DELETE"/>
                                                <button class="btn btn-outline-danger" title="@lang('labels.general.buttons.delete')"><i
                                                            class="far fa-trash-alt"></i>
                                                </button>
                                            </form>

                                        </div><!--btn-toolbar-->
                                    </td>
                                </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!--col-->
            </div><!--row-->

        </div><!--card-body-->
    </div><!--card-->

    @if($deleted->count() > 0)

        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="text-danger mb-0 mr-1">@lang('labels.frontend.tours.meal.deleted')</h6>
                        </div>
                    </div><!--col-->
                </div><!--row-->

                <div class="row mt-4">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>@lang('labels.frontend.tours.meal.table.name')</th>
                                    <th><div class="float-right">@lang('labels.general.actions')</div></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($deleted as $item)
                                    <tr>
                                        <td>{{$item->name}}</td>
                                        <td>
                                            <div class="float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                                                <a href="{{ route('frontend.tour.meal.restore', $item->id) }}" class="btn btn-outline-success ml-1" data-toggle="tooltip" title="@lang('labels.general.buttons.restore')">
                                                    <i class="fas fa-sync"></i></a>
                                                <form style="display: inline-block;" action="{{ route('frontend.tour.meal.delete-permanently', $item->id) }}" method="post">
                                                    {!! csrf_field() !!}
                                                    <input type="hidden" name="_method" value="DELETE"/>
                                                    <button class="btn btn-outline-danger" title="@lang('labels.general.buttons.delete-permanently')"><i
                                                                class="far fa-trash-alt"></i>
                                                    </button>
                                                </form>

                                            </div><!--btn-toolbar-->
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