{{ html()->form($method, $route)->class('form-horizontal')->open() }}

<div class="row mt-4">
    <div class="col">
        <div class="form-group row">
            {{ html()->label(__('validation.attributes.frontend.general.name'))
                ->class('col-md-2 form-control-label')
                ->for('name') }}

            <div class="col-md-10">
                {{ html()->text('name', $item->name??'')
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
            {{ html()->label(__('labels.frontend.tours.type.name'))
                ->class('col-md-2 form-control-label')
                ->for('tour_type_id') }}

            <div class="col-md-10">
                {{ html()->select('tour_type_id')
                ->value($item->tour_type_id??'')
                ->options($tour_type_options)->class('form-control') }}
            </div><!--col-->
        </div><!--form-group-->

    </div><!--col-->
</div><!--row-->

<div class="row mt-4">
    <div class="col">
        <div class="form-group row">
            {{ html()->label(__('validation.attributes.frontend.general.date'))
                ->class('col-md-2 form-control-label')
                ->for('dates[]') }}

            <div class="col-md-10">
                {{ html()->text('dates[]', $tour_dates[0]??'')
                    ->class('form-control')
                    ->placeholder(__('validation.attributes.frontend.general.date'))
                    ->attribute('maxlength', 191)
                    ->required() }}
            </div><!--col-->
        </div><!--form-group-->

    </div><!--col-->
</div><!--row-->

<div class="row mt-4">
    <div class="col">
        <div class="form-group row">
            {{ html()->label(__('validation.attributes.frontend.general.date'))
                ->class('col-md-2 form-control-label')
                ->for('dates[]') }}

            <div class="col-md-10">
                {{ html()->text('dates[]', $tour_dates[1]??'')
                    ->class('form-control')
                    ->placeholder(__('validation.attributes.frontend.general.date'))
                    ->attribute('maxlength', 191) }}
            </div><!--col-->
        </div><!--form-group-->

    </div><!--col-->
</div><!--row-->

{{--<div class="row mt-4">
    <div class="col">
        <div class="form-group row">
            {{ html()->label(__('labels.frontend.tours.city.name'))
                ->class('col-md-2 form-control-label')
                ->for('name') }}

            <div class="col-md-10">
                {{ html()->select('city_id')
                ->value($item->city_id??'')
                ->options($cities_options)->class('form-control') }}
            </div><!--col-->
        </div><!--form-group-->

    </div><!--col-->
</div><!--row-->--}}

@if(count($cities_options)>0)
    <div class="row mt-4">
        <div class="col">
            <div class="form-group row">
                {{ html()->label(__('labels.frontend.tours.city.name'))
                    ->class('col-md-2 form-control-label') }}

                <div class="col-md-10">
                    @foreach ($cities_options as $city_id => $city_name)
                        <div class="custom-control custom-checkbox">
                            {{ html()->checkbox('cities_list[]', in_array($city_id, []), $city_id)->class('custom-control-input')->id('city_chk_' . $city_id) }}
                            {{ html()->label($city_name)->class('custom-control-label')->for('city_chk_' . $city_id) }}
                        </div>
                    @endforeach
                </div><!--col-->
            </div><!--form-group-->

        </div><!--col-->
    </div><!--row-->
@endif

<div class="row mt-4">
    <div class="col">
        <div class="form-group row">
            {{ html()->label(__('validation.attributes.frontend.general.duration'))
                ->class('col-md-2 form-control-label')
                ->for('duration') }}

            <div class="col-md-10">
                {{ html()->input('number', 'duration', $item->duration??'')
                    ->class('form-control')
                    ->placeholder(__('validation.attributes.frontend.general.duration'))
                    ->attribute('maxlength', 191) }}
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
                {{ html()->text('description', $item->description??'')
                    ->class('form-control')
                    ->placeholder(__('validation.attributes.frontend.general.description'))
                    ->attribute('maxlength', 191) }}
            </div><!--col-->
        </div><!--form-group-->

    </div><!--col-->
</div><!--row-->

<hr>

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