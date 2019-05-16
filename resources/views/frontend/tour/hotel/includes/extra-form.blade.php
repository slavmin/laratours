{{ html()->form('PATCH', route('frontend.tour.hotel.update', $item->id))->class('form-horizontal')->open() }}

{{ html()->hidden('attribute['.$attribute['id'].'][id]')
    ->value($attribute['id']??'') }}

<div class="card mt-4">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h6 class="card-title mb-0">
                    @lang('labels.frontend.tours.hotel.attributes.create')
                </h6>
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
                        {{ html()->text('attribute['.$attribute['id'].'][name]')
                            ->class('form-control')
                            ->placeholder(__('validation.attributes.frontend.general.name'))
                            ->attribute('maxlength', 191)
                            ->value($attribute['name']??'')
                            ->required()
                            ->autofocus() }}
                    </div><!--col-->
                </div><!--form-group-->

            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="form-group row">
                    {{ html()->label(__('validation.attributes.frontend.general.price'))
                        ->class('col-md-2 form-control-label')
                        ->for('price') }}

                    <div class="col-md-10">
                        {{ html()->input()
                            ->name('attribute['.$attribute['id'].'][price]')
                            ->type('number')
                            ->class('form-control')
                            ->placeholder(__('validation.attributes.frontend.general.price'))
                            ->attribute('maxlength', 191)
                            ->value($attribute['price']??'')
                            ->autofocus() }}
                    </div><!--col-->
                </div><!--form-group-->

            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="form-group row">
                    {{ html()->label(__('labels.frontend.tours.customer.type.name'))
                        ->class('col-md-2 form-control-label')
                        ->for('customer_type_id') }}

                    <div class="col-md-10">
                        {{ html()->select('attribute['.$attribute['id'].'][customer_type_id]')
                            ->value($attribute['customer_type_id']??'')
                            ->options($customer_type_options)->class('form-control') }}
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
                            ->name('attribute['.$attribute['id'].'][qnt]')
                            ->type('number')
                            ->class('form-control')
                            ->placeholder(__('validation.attributes.frontend.general.qnt'))
                            ->attribute('maxlength', 191)
                            ->value($attribute['qnt']??'')
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
                        {{ html()->text('attribute['.$attribute['id'].'][description]')
                            ->class('form-control')
                            ->placeholder(__('validation.attributes.frontend.general.description'))
                            ->attribute('maxlength', 191)
                            ->value($attribute['description']??'')
                            ->autofocus() }}
                    </div><!--col-->
                </div><!--form-group-->

            </div><!--col-->
        </div><!--row-->

    </div><!--card-body-->

    <div class="card-footer">
        <div class="row">
            <div class="col">
                {{ form_cancel(route('frontend.tour.hotel.index'), __('buttons.general.cancel')) }}
            </div><!--col-->

            <div class="col text-right">
                {{ form_submit(__('buttons.general.crud.update')) }}
            </div><!--col-->
        </div><!--row-->
    </div><!--card-footer-->
</div><!--card-->
{{ html()->form()->close() }}