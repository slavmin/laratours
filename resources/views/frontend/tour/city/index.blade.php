@extends('frontend.layouts.app')

@section('content')
    <div class="card">
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
                            @foreach($cities as $city)
                                <tr>
                                    <td>{{$city->name}}</td>
                                    <td>
                                        <div class="float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                                            <a href="{{ route('frontend.tour.city.edit', [$country->id, $city->id]) }}" class="btn btn-outline-success ml-1" data-toggle="tooltip" title="@lang('labels.general.buttons.update')">
                                                <i class="fas fa-edit"></i></a>
                                            <form style="display: inline-block;" action="{{ route('frontend.tour.city.destroy', [$country->id, $city->id]) }}" method="post">
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
                            </tbody>
                        </table>
                    </div>
                </div><!--col-->
            </div><!--row-->

        </div><!--card-body-->
    </div><!--card-->
@endsection