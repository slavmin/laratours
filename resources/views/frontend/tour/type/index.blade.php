@extends('frontend.layouts.app')

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="text-info mb-0 mr-1">@lang('labels.frontend.tours.type.management')</h6>
                        <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                            <a href="{{ route('frontend.tour.type.create') }}" class="btn btn-success ml-1" data-toggle="tooltip" title="@lang('buttons.general.crud.create')">
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
                                <th>@lang('labels.frontend.tours.type.table.name')</th>
                                <th><div class="float-right">@lang('labels.general.actions')</div></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td>
                                        <div class="float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                                            <a href="{{ route('frontend.tour.type.edit', $item->id) }}" class="btn btn-outline-success ml-1" data-toggle="tooltip" title="@lang('labels.general.buttons.update')">
                                                <i class="fas fa-edit"></i></a>
                                            <form style="display: inline-block;" action="{{ route('frontend.tour.type.destroy', $item->id) }}" method="post">
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

    <div class="row mb-4">
        <div class="col-9">
            <div class="float-left">
                {!! $items->links() !!}
            </div>
        </div><!--col-->
        <div class="col-3">
            <div class="float-right">
                {!! $items->total() !!} {{ trans_choice('labels.general.table.total', $items->total()) }}
            </div>
        </div><!--col-->
    </div><!--row-->

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
                                    <th>@lang('labels.frontend.tours.country.table.name')</th>
                                    <th><div class="float-right">@lang('labels.general.actions')</div></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($deleted as $item)
                                    <tr>
                                        <td>{{$item->name}}</td>
                                        <td>
                                            <div class="float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                                                <a href="{{ route('frontend.tour.type.restore', $item->id) }}" class="btn btn-outline-success ml-1" data-toggle="tooltip" title="@lang('labels.general.buttons.restore')">
                                                    <i class="fas fa-sync"></i></a>
                                                <form style="display: inline-block;" action="{{ route('frontend.tour.type.delete-permanently', $item->id) }}" method="post">
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