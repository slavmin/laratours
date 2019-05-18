@extends('frontend.layouts.app')

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="text-info mb-0 mr-1 flex-grow-1">
                            <nav aria-label="breadcrumb">
                                <ol class="list-unstyled d-inline">
                                    <li class="breadcrumb-item d-inline"><a class="text-info text-decoration-none" href="{{ route('frontend.tour.country.index') }}">@lang('labels.frontend.tours.country.management')</a></li>
                                    <li class="breadcrumb-item d-inline">{{ $country->name }}</li>
                                    <li class="breadcrumb-item d-inline active" aria-current="page">@lang('labels.frontend.tours.city.management')</li>
                                </ol>
                            </nav>
                        </h6>
                        <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                            <a href="{{ route('frontend.tour.city.create', $country->id) }}" class="btn btn-success ml-1" data-toggle="tooltip" title="@lang('buttons.general.crud.create')">
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
                                <th>@lang('labels.frontend.tours.city.table.name')</th>
                                <th><div class="float-right">@lang('labels.general.actions')</div></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{$item->name}}</td>
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

    @include('frontend.tour.includes.pagination-row')

    @include('frontend.tour.includes.trash-bin')

@endsection