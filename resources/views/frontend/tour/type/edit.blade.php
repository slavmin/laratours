@extends('frontend.layouts.app')

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col col-sm-8 align-self-center">

            {{ html()->form('PATCH', route('frontend.tour.type.update', $tour_type->id))->class('form-horizontal')->open() }}
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <h5 class="card-title mb-0">
                                @lang('labels.frontend.tours.type.edit')
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
                                        ->value($tour_type->name)
                                        ->required()
                                        ->autofocus() }}
                                </div><!--col-->
                            </div><!--form-group-->

                        </div><!--col-->
                    </div><!--row-->
                </div><!--card-body-->

                <div class="card-footer">
                    <div class="row">
                        <div class="col">
                            {{ form_cancel(route('frontend.tour.type.index'), __('buttons.general.cancel')) }}
                        </div><!--col-->

                        <div class="col text-right">
                            {{ form_submit(__('buttons.general.crud.update')) }}
                        </div><!--col-->
                    </div><!--row-->
                </div><!--card-footer-->
            </div><!--card-->
            {{ html()->form()->close() }}

        </div><!-- col-md-8 -->
    </div><!-- row -->
@endsection
