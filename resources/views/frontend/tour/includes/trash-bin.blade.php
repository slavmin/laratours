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
                                <th>@lang('labels.general.table.name')</th>
                                <th><div class="float-right">@lang('labels.general.actions')</div></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($deleted as $item)
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

@endif