{{ html()->form($method, $route)->class('form-horizontal')->open() }}

    {{ html()->hidden('tour_id')->value($tour->id??0) }}
    {{ html()->hidden('operator_id')->value($tour->team_id??0) }}

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
