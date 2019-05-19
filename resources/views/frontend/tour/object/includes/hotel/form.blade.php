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
            {{ html()->label(__('validation.attributes.frontend.general.qnt'))
                ->class('col-md-2 form-control-label')
                ->for('qnt') }}

            <div class="col-md-10">
                {{ html()->input('number', 'qnt', $item->qnt??'')
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
                {{ html()->text('description', $item->description??'')
                    ->class('form-control')
                    ->placeholder(__('validation.attributes.frontend.general.description'))
                    ->attribute('maxlength', 191)
                    ->autofocus() }}
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