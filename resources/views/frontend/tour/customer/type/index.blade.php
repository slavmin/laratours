@extends('frontend.layouts.app')

@section('content')
    <div class="container tc-blue-bg">
        <div class="row">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Add customer Vue-component -->
                    <customer-type-add
                        header="@lang('labels.frontend.tours.customer.type.create')"
                        token="{{ csrf_token() }}"
                    ></customer-type-add>
                    <!-- /Add customer Vue-component -->
                    <!-- <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                        <a href="{{ route('frontend.tour.customer-type.create') }}" class="btn btn-success ml-1" data-toggle="tooltip" title="@lang('buttons.general.crud.create')">
                            <i class="fas fa-plus"></i></a>
                    </div> --><!--btn-toolbar-->
                </div>
            </div><!--col-->
        </div><!--row-->

        @if(count($items)>0)
        <?php $sitems = json_encode($items); ?>
        <!-- Table customers Vue-component -->
        <customer-type-table
            :items="{{ $sitems }}"
            data-app
            header-edit="@lang('labels.frontend.tours.customer.type.edit')"
            token="{{ csrf_token() }}"
        ></customer-type-table>
        <!-- /Table customers Vue-component -->
        <!-- Original table vvvvvvv -->
        <!-- <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>@lang('labels.frontend.tours.customer.type.table.name')</th>
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
                                    </div>float-right-->
                                <!-- </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>-col
        </div>row-->
        @endif
    </div>

    @include('frontend.tour.includes.pagination-row')

    @include('frontend.tour.includes.trash-bin')

@endsection