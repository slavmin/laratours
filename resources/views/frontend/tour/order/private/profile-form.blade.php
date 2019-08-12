<div class="row">
    <div class="col">
        <div class="form-group">
            {{ html()->label(__('validation.attributes.frontend.customer.first_name'))->for('first_name') }}

            {{ html()->text('customer['.$i.'][first_name]', $profile['first_name']??'')
                ->class('form-control')
                ->id('first_name')
                ->placeholder(__('validation.attributes.frontend.customer.first_name'))
                ->attribute('maxlength', 191)
                ->required() }}
        </div><!--form-group-->
    </div><!--col-->
</div><!--row-->

<div class="row">
    <div class="col">
        <div class="form-group">
            {{ html()->label(__('validation.attributes.frontend.customer.last_name'))->for('last_name') }}

            {{ html()->text('customer['.$i.'][last_name]', $profile['last_name']??'')
                ->class('form-control')
                ->id('last_name')
                ->placeholder(__('validation.attributes.frontend.customer.last_name'))
                ->attribute('maxlength', 191)
                ->required() }}
        </div><!--form-group-->
    </div><!--col-->
</div><!--row-->

<div class="row">
    <div class="col-12 col-md-6">
        <div class="form-group">
            {{ html()->label(__('validation.attributes.frontend.customer.phone'))->for('phone') }}

            {{ html()->text('customer['.$i.'][phone]', $profile['phone']??'')
                ->class('form-control')
                ->id('phone')
                ->placeholder(__('validation.custom.phone_format'))
                ->attribute('maxlength', 191)
                ->required()}}
        </div><!--form-group-->
    </div><!--row-->

    <div class="col-12 col-md-6">
        <div class="form-group">
            {{ html()->label(__('validation.attributes.frontend.customer.email'))->for('email') }}

            {{ html()->email('customer['.$i.'][email]', $profile['email']??'')
                ->class('form-control')
                ->id('email')
                ->placeholder(__('validation.attributes.frontend.customer.email'))
                ->attribute('maxlength', 191)
                ->required()}}
        </div><!--form-group-->
    </div><!--col-->
</div><!--row-->

<div class="row">
    <div class="col-12 col-md-6">
        <div class="form-group">
            {{ html()->label(__('validation.attributes.frontend.customer.country'))->for('country') }}

            {{ html()->text('customer['.$i.'][country]', $profile['country']??'')
                ->class('form-control')
                ->id('country')
                ->placeholder(__('validation.attributes.frontend.customer.country'))
                ->attribute('maxlength', 191)
                ->required()}}
        </div><!--form-group-->
    </div><!--row-->

    <div class="col-12 col-md-6">
        <div class="form-group">
            {{ html()->label(__('validation.attributes.frontend.customer.city'))->for('city') }}

            {{ html()->text('customer['.$i.'][city]', $profile['city']??'')
                ->class('form-control')
                ->id('city')
                ->placeholder(__('validation.attributes.frontend.customer.city'))
                ->attribute('maxlength', 191)
                ->required()}}
        </div><!--form-group-->
    </div><!--col-->
</div><!--row-->

<div class="row">
    <div class="col">
        <div class="form-group">
            {{ html()->label(__('validation.attributes.frontend.customer.address'))->for('address') }}

            {{ html()->text('customer['.$i.'][address]', $profile['address']??'')
                ->class('form-control')
                ->id('address')
                ->placeholder(__('validation.attributes.frontend.customer.address'))
                ->attribute('maxlength', 191)
                ->required()}}
        </div><!--form-group-->
    </div><!--col-->
</div><!--row-->

<div class="row">
    <div class="col">
        <div class="form-group">
            {{ html()->label(__('validation.attributes.frontend.customer.passport'))->for('address') }}

            {{ html()->text('customer['.$i.'][passport]', $profile['passport']??'')
                ->class('form-control')
                ->id('passport')
                ->placeholder(__('validation.attributes.frontend.customer.passport'))
                ->attribute('maxlength', 191)
                ->required()}}
        </div><!--form-group-->
    </div><!--col-->
</div><!--row-->