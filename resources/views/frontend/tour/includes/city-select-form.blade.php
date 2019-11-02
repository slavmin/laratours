<div class="card mb-4">
    <div class="card-body py-3">

        <div class="row">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="text-info mb-0 mr-1">{{ $city_name }}</h6>
                    <div class="float-right">
                        {{ html()->form('GET', route('frontend.tour.'.$model_alias.'.index'))->class('form-horizontal')->open() }}
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

                                    {{ html()->submit(__('buttons.general.crud.update'))->class('btn btn-success btn-sm') }}

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