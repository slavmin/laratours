@extends('frontend.layouts.app')

@section('content')
    <div class="container-xl pt-4">
        @include('frontend.tour.type.includes.header')
        <div class="row justify-center mb-4">
            <a 
                href="{{ route('frontend.tour.type.create') }}" 
                class="btn btn-success ml-1" 
                data-toggle="tooltip" 
                title="@lang('buttons.general.crud.create')"
            >
                <i class="fas fa-plus"></i>
            </a>
        </div>
        <div class="card mb-4">    
            <div class="card-body">
                @if(count($items)>0)
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
    </div>

    @include('frontend.tour.includes.pagination-row')

    @include('frontend.tour.includes.trash-bin')

@endsection