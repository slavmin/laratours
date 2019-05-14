@extends('frontend.layouts.app')

@section('content')

    <div class="card mb-4">
        <div class="card-body py-3">

            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="text-info mb-0 mr-1">{{ $city_name }}</h6>
                        <div class="float-right">
                            {{ html()->form('GET', route('frontend.tour.museum.index'))->class('form-horizontal')->open() }}
                            <div class="form-row align-items-center float-right">
                                <div class="col-auto">
                                    <div class="form-group mb-0">

                                        {{ html()->select('city_id')
                                        ->value($city_id)
                                        ->options($cities_select)->class('form-control form-control-sm') }}

                                    </div><!--form-group-->
                                </div><!--col-->

                                <div class="col-auto">
                                    <div class="form-group mb-0">

                                        {{ form_submit(__('buttons.general.crud.update')) }}

                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--form-row-->
                            {{ html()->form()->close() }}
                        </div><!--float-right-->
                    </div>
                </div><!--col-->
            </div><!--row-->

        </div><!--card-body-->
    </div><!--card-->


    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="text-info mb-0 mr-1">@lang('labels.frontend.tours.museum.management')</h6>
                        <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                            <a href="{{ route('frontend.tour.museum.create', $city_param) }}" class="btn btn-success ml-1" data-toggle="tooltip" title="@lang('buttons.general.crud.create')">
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
                                <th>@lang('labels.frontend.tours.museum.table.name')</th>
                                <th>@lang('labels.frontend.tours.tour.city')</th>
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
                                        <td>
                                            <div class="float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                                                <a href="{{ route('frontend.tour.museum.edit', $item->id) }}" class="btn btn-outline-success ml-1" data-toggle="tooltip" title="@lang('labels.general.buttons.update')">
                                                    <i class="fas fa-edit"></i></a>
                                                <form style="display: inline-block;" action="{{ route('frontend.tour.museum.destroy', $item->id) }}" method="post">
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
                            <h6 class="text-danger mb-0 mr-1">@lang('labels.frontend.tours.museum.deleted')</h6>
                        </div>
                    </div><!--col-->
                </div><!--row-->

                <div class="row mt-4">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>@lang('labels.frontend.tours.museum.table.name')</th>
                                    <th><div class="float-right">@lang('labels.general.actions')</div></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($deleted as $item)
                                    <tr>
                                        <td>{{$item->name}}</td>
                                        <td>
                                            <div class="float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                                                <a href="{{ route('frontend.tour.museum.restore', $item->id) }}" class="btn btn-outline-success ml-1" data-toggle="tooltip" title="@lang('labels.general.buttons.restore')">
                                                    <i class="fas fa-sync"></i></a>
                                                <form style="display: inline-block;" action="{{ route('frontend.tour.museum.delete-permanently', $item->id) }}" method="post">
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