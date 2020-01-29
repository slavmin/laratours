{{ html()->form($method, $route)->class('form-horizontal')->open() }}

<div class="row mt-4">
    <div class="col">
        <div class="form-group md-form">
            {{ html()->label(__('validation.attributes.frontend.general.name'))
                ->for('name') }}
            {{ html()->text('name', $item->name??'')
                    ->class('form-control')
                    ->attribute('maxlength', 191)
                    ->required()
                    ->autofocus() }}
        </div><!--form-group-->

    </div><!--col-->
</div><!--row-->

<div class="row mt-4">
    <div class="col">
        <div class="form-group md-form">
            {{ html()->label(__('validation.attributes.frontend.general.description'))
                ->for('description') }}

            {{ html()->text('description', $item->description??'')
                ->class('form-control')
                ->attribute('maxlength', 191) }}
        </div><!--form-group-->

    </div><!--col-->
</div><!--row-->

<hr>

<div class="row mt-4">
    <div class="col">
        <div class="form-group row">
            <div class="col">
                {{ html()->a($cancel_route, __('buttons.general.cancel'))->class('btn btn-outline-primary') }}
            </div><!--col-->

            <div class="col text-right">
                {{ html()->submit(__('buttons.general.crud.update'))->class('btn btn-primary') }}
            </div><!--col-->
        </div><!--form-group-->

    </div><!--col-->
</div><!--row-->

{{ html()->form()->close() }}