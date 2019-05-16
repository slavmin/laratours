<div class="card mb-4">
    <div class="card-header">
        <strong>
            @lang('labels.frontend.teams.profile') @isset($type){{ $type=='formal' ? 'юридические' : 'фактические' }}@endisset
        </strong>
    </div><!--card-header-->

    <div class="card-body">
        {{ html()->form('PATCH', route('frontend.user.team.edit.post', $team->id))->open() }}

        {{ html()->hidden('profile_type')
            ->value($type) }}

        <div class="row">
            <div class="col">
                <div class="form-group">
                    {{ html()->label(__('validation.attributes.frontend.company.name'))->for('company_name') }}

                    {{ html()->text(config('teamwork.extra_field_name').'['.$type.'][company_name]', $profile['company_name']??'')
                        ->class('form-control')
                        ->id('company_name')
                        ->placeholder(__('validation.attributes.frontend.company.name'))
                        ->attribute('maxlength', 191)
                        ->required() }}
                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    {{ html()->label(__('validation.attributes.frontend.company.phone'))->for('company_phone') }}

                    {{ html()->text(config('teamwork.extra_field_name').'['.$type.'][company_phone]', $profile['company_phone']??'')
                        ->class('form-control')
                        ->id('company_phone')
                        ->placeholder(__('validation.attributes.frontend.company.phone'))
                        ->attribute('maxlength', 191)
                        ->required()}}
                </div><!--form-group-->
            </div><!--row-->

            <div class="col-12 col-md-6">
                <div class="form-group">
                    {{ html()->label(__('validation.attributes.frontend.company.email'))->for('company_email') }}

                    {{ html()->email(config('teamwork.extra_field_name').'['.$type.'][company_email]', $profile['company_email']??'')
                        ->class('form-control')
                        ->id('company_email')
                        ->placeholder(__('validation.attributes.frontend.company.email'))
                        ->attribute('maxlength', 191)
                        ->required()}}
                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    {{ html()->label(__('validation.attributes.frontend.company.country'))->for('company_country') }}

                    {{ html()->text(config('teamwork.extra_field_name').'['.$type.'][company_country]', $profile['company_country']??'')
                        ->class('form-control')
                        ->id('company_country')
                        ->placeholder(__('validation.attributes.frontend.company.country'))
                        ->attribute('maxlength', 191)
                        ->required()}}
                </div><!--form-group-->
            </div><!--row-->

            <div class="col-12 col-md-6">
                <div class="form-group">
                    {{ html()->label(__('validation.attributes.frontend.company.city'))->for('company_city') }}

                    {{ html()->text(config('teamwork.extra_field_name').'['.$type.'][company_city]', $profile['company_city']??'')
                        ->class('form-control')
                        ->id('company_city')
                        ->placeholder(__('validation.attributes.frontend.company.city'))
                        ->attribute('maxlength', 191)
                        ->required()}}
                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->

        <div class="row">
            <div class="col">
                <div class="form-group">
                    {{ html()->label(__('validation.attributes.frontend.company.address'))->for('company_address') }}

                    {{ html()->text(config('teamwork.extra_field_name').'['.$type.'][company_address]', $profile['company_address']??'')
                        ->class('form-control')
                        ->id('company_address')
                        ->placeholder(__('validation.attributes.frontend.company.address'))
                        ->attribute('maxlength', 191)
                        ->required()}}
                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    {{ html()->label(__('validation.attributes.frontend.company.inn'))->for('company_inn') }}

                    {{ html()->text(config('teamwork.extra_field_name').'['.$type.'][company_inn]', $profile['company_inn']??'')
                        ->class('form-control')
                        ->id('company_inn')
                        ->placeholder(__('validation.attributes.frontend.company.inn'))
                        ->attribute('maxlength', 191)
                        ->required()}}
                </div><!--form-group-->
            </div><!--row-->

            <div class="col-12 col-md-6">
                <div class="form-group">
                    {{ html()->label(__('validation.attributes.frontend.company.kpp'))->for('company_kpp') }}

                    {{ html()->text(config('teamwork.extra_field_name').'['.$type.'][company_kpp]', $profile['company_kpp']??'')
                        ->class('form-control')
                        ->id('company_kpp')
                        ->placeholder(__('validation.attributes.frontend.company.kpp'))
                        ->attribute('maxlength', 191)
                        ->required()}}
                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->

        <div class="row">
            <div class="col">
                {{ form_cancel(route('frontend.user.team'), __('buttons.general.cancel')) }}
            </div><!--col-->

            <div class="col text-right">
                {{ form_submit(__('buttons.general.save')) }}
            </div><!--col-->
        </div><!--row-->
        {{ html()->form()->close() }}

    </div><!-- card-body -->
</div><!-- card -->