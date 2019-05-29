{{ html()->form($method, $route)->class('form-horizontal')->open() }}

@can('administer-tours')
<div class="row mt-4">
    <div class="col">
        <div class="form-group row">
            {{ html()->label(__('labels.frontend.tours.order.status'))
                ->class('col-md-2 form-control-label')
                ->for('status') }}

            <div class="col-md-10">
                {{ html()->select('status', __('labels.frontend.tours.order.statuses'), $item->status??0)
                ->class('form-control') }}
            </div><!--col-->
        </div><!--form-group-->

    </div><!--col-->
</div><!--row-->
<hr>
@endcan

@if(count($profiles) > 0)
    @foreach($profiles as $i => $profile)
        @include('frontend.tour.order.private.profile-form')
        <hr />
    @endforeach
@endif

<div class="row mt-4">
    <div class="col">
        <div class="form-group row">
            <div class="col">
                {{ html()->a($cancel_route, __('buttons.general.cancel'))->class('btn btn-outline-info btn-sm') }}
            </div><!--col-->

            <div class="col text-right">
                {{ html()->submit(__('buttons.general.crud.update'))->class('btn btn-success btn-sm') }}
            </div><!--col-->
        </div><!--form-group-->

    </div><!--col-->
</div><!--row-->

{{ html()->form()->close() }}