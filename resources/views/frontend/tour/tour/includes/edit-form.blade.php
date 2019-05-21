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
</div><!--row-->

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
{{--<div class="row mt-4">
    <div class="col">
        <div class="form-group row">
            {{ html()->label(__('labels.frontend.tours.guide.name'))
                ->class('col-md-2 form-control-label')
                ->for('guide_id[]') }}

            <div class="col-md-10">
                {{ html()->multiselect('guide_id[]', $guides_options, $guides??[])
                ->class('form-control') }}
            </div><!--col-->
        </div><!--form-group-->

    </div><!--col-->
</div><!--row-->--}}

<div class="row mt-4">
    <div class="col">
        <div class="form-group row">
            {{ html()->label(__('labels.frontend.tours.hotel.name'))
                ->class('col-md-3 form-control-label') }}

            <div class="col-md-9">
                @foreach ($hotel_options as $hotel_id => $hotel_name)
                    <div class="custom-control custom-checkbox">
                        {{ html()->checkbox('hotel_id[]', in_array($hotel_id, $attributes['hotels']), $hotel_id)->class('custom-control-input')->id('hotel_chk_' . $hotel_id) }}
                        {{ html()->label($hotel_name)->class('custom-control-label')->for('hotel_chk_' . $hotel_id) }}
                    </div>
                @endforeach
            </div><!--col-->
        </div><!--form-group-->

    </div><!--col-->
</div><!--row-->

<div class="row mt-4">
    <div class="col">
        <div class="form-group row">
            {{ html()->label(__('labels.frontend.tours.museum.name'))
                ->class('col-md-3 form-control-label') }}

            <div class="col-md-9">
                @foreach ($museum_options as $museum_id => $museum_name)
                    <div class="custom-control custom-checkbox">
                        {{ html()->checkbox('museum_id[]', in_array($museum_id, $attributes['museums']), $museum_id)->class('custom-control-input')->id('museum_chk_' . $museum_id) }}
                        {{ html()->label($museum_name)->class('custom-control-label')->for('museum_chk_' . $museum_id) }}
                    </div>
                @endforeach
            </div><!--col-->
        </div><!--form-group-->

    </div><!--col-->
</div><!--row-->

<div class="row mt-4">
    <div class="col">
        <div class="form-group row">
            {{ html()->label(__('labels.frontend.tours.meal.name'))
                ->class('col-md-3 form-control-label') }}

            <div class="col-md-9">
                @foreach ($meal_options as $meal_id => $meal_name)
                    <div class="custom-control custom-checkbox">
                        {{ html()->checkbox('meal_id[]', in_array($meal_id, $attributes['meals']), $meal_id)->class('custom-control-input')->id('meal_chk_' . $meal_id) }}
                        {{ html()->label($meal_name)->class('custom-control-label')->for('meal_chk_' . $meal_id) }}
                    </div>
                @endforeach
            </div><!--col-->
        </div><!--form-group-->

    </div><!--col-->
</div><!--row-->

<div class="row mt-4">
    <div class="col">
        <div class="form-group row">
            {{ html()->label(__('labels.frontend.tours.transport.name'))
                ->class('col-md-3 form-control-label') }}

            <div class="col-md-9">
                @foreach ($transport_options as $transport_id => $transport_name)
                    <div class="custom-control custom-checkbox">
                        {{ html()->checkbox('transport_id[]', in_array($transport_id, $attributes['transports']), $transport_id)->class('custom-control-input')->id('transport_chk_' . $transport_id) }}
                        {{ html()->label($transport_name)->class('custom-control-label')->for('transport_chk_' . $transport_id) }}
                    </div>
                @endforeach
            </div><!--col-->
        </div><!--form-group-->

    </div><!--col-->
</div><!--row-->

<div class="row mt-4">
    <div class="col">
        <div class="form-group row">
            {{ html()->label(__('labels.frontend.tours.guide.name'))
                ->class('col-md-3 form-control-label') }}

            <div class="col-md-9">
                @foreach ($guide_options as $guide_id => $guide_name)
                    <div class="custom-control custom-checkbox">
                        {{ html()->checkbox('guide_id[]', in_array($guide_id, $attributes['guides']), $guide_id)->class('custom-control-input')->id('guide_chk_' . $guide_id) }}
                        {{ html()->label($guide_name)->class('custom-control-label')->for('guide_chk_' . $guide_id) }}
                    </div>
                @endforeach
            </div><!--col-->
        </div><!--form-group-->

    </div><!--col-->
</div><!--row-->

<div class="row mt-4">
    <div class="col">
        <div class="form-group row">
            {{ html()->label(__('labels.frontend.tours.attendant.name'))
                ->class('col-md-3 form-control-label') }}

            <div class="col-md-9">
                @foreach ($attendant_options as $attendant_id => $attendant_name)
                    <div class="custom-control custom-checkbox">
                        {{ html()->checkbox('attendant_id[]', in_array($attendant_id, $attributes['attendants']), $attendant_id)
                            ->class('custom-control-input')
                            ->id('attendant_chk_' . $attendant_id) }}
                        {{ html()->label($attendant_name)->class('custom-control-label')->for('attendant_chk_' . $attendant_id) }}
                    </div>
                @endforeach
            </div><!--col-->
        </div><!--form-group-->

    </div><!--col-->
</div><!--row-->

<hr>

<div class="row mt-4">
    <div class="col">
        <div class="form-group row">
            <div class="col">
                {{ form_cancel($cancel_route, __('buttons.general.cancel')) }}
            </div><!--col-->

            <div class="col text-right">
                {{ form_submit(__('buttons.general.crud.update')) }}
            </div><!--col-->
        </div><!--form-group-->

    </div><!--col-->
</div><!--row-->

{{ html()->form()->close() }}