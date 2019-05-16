@extends('frontend.layouts.app')

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col col-sm-8 align-self-center">


            {{ html()->form('POST', route('frontend.tour.meal.store'))->class('form-horizontal')->open() }}
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <h5 class="card-title mb-0">
                                @lang('labels.frontend.tours.meal.create')
                            </h5>
                        </div><!--col-->
                    </div><!--row-->

                    <hr>

                    <div class="row mt-4">
                        <div class="col">
                            <div class="form-group row">
                                {{ html()->label(__('validation.attributes.frontend.general.name'))
                                    ->class('col-md-2 form-control-label')
                                    ->for('name') }}

                                <div class="col-md-10">
                                    {{ html()->text('name')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.general.name'))
                                        ->attribute('maxlength', 191)
                                        ->required()
                                        ->autofocus() }}
                                </div><!--col-->
                            </div><!--form-group-->

                        </div><!--col-->
                    </div><!--row-->

                    <div class="row mt-4">
                        <div class="col">
                            <div class="form-group row">
                                {{ html()->label(__('labels.frontend.tours.city.name'))
                                    ->class('col-md-2 form-control-label')
                                    ->for('city_id') }}

                                <div class="col-md-10">
                                    {{ html()->select('city_id')->value($city_id)->options($cities_options)->class('form-control') }}
                                </div><!--col-->
                            </div><!--form-group-->

                        </div><!--col-->
                    </div><!--row-->

                    <div class="row mt-4">
                        <div class="col">
                            <div class="form-group row">
                                {{ html()->label(__('validation.attributes.frontend.general.qnt'))
                                    ->class('col-md-2 form-control-label')
                                    ->for('qnt') }}

                                <div class="col-md-10">
                                    {{ html()->input()
                                        ->name('qnt')
                                        ->type('number')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.general.qnt'))
                                        ->attribute('maxlength', 191)
                                        ->autofocus() }}
                                </div><!--col-->
                            </div><!--form-group-->

                        </div><!--col-->
                    </div><!--row-->

                    <div class="row mt-4">
                        <div class="col">
                            <div class="form-group row">
                                {{ html()->label(__('validation.attributes.frontend.general.description'))
                                    ->class('col-md-2 form-control-label')
                                    ->for('description') }}

                                <div class="col-md-10">
                                    {{ html()->text('description')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.general.description'))
                                        ->attribute('maxlength', 191)
                                        ->autofocus() }}
                                </div><!--col-->
                            </div><!--form-group-->

                        </div><!--col-->
                    </div><!--row-->

                </div><!--card-body-->

                <div class="card-footer">
                    <div class="row">
                        <div class="col">
                            {{ form_cancel(route('frontend.tour.meal.index'), __('buttons.general.cancel')) }}
                        </div><!--col-->

                        <div class="col text-right">
                            {{ form_submit(__('buttons.general.crud.create')) }}
                        </div><!--col-->
                    </div><!--row-->
                </div><!--card-footer-->
            </div><!--card-->
            {{ html()->form()->close() }}


        </div><!-- col-md-8 -->
    </div><!-- row -->
@endsection