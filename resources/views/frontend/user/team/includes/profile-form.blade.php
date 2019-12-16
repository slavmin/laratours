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
            <div class="col">
                <div class="form-group">
                    {{ html()->label(__('validation.attributes.frontend.company.full_name'))->for('company_full_name') }}

                    {{ html()->text(config('teamwork.extra_field_name').'['.$type.'][company_full_name]', $profile['company_full_name']??'')
                        ->class('form-control')
                        ->id('company_full_name')
                        ->placeholder(__('validation.attributes.frontend.company.full_name'))
                        ->attribute('maxlength', 191)
                        ->required() }}
                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->

        <div class="row">
            <div class="col">
                <div class="form-group">
                    {{ html()->label(__('validation.attributes.frontend.company.ceo_name'))->for('company_ceo_name') }}

                    {{ html()->text(config('teamwork.extra_field_name').'['.$type.'][company_ceo_name]', $profile['company_ceo_name']??'')
                        ->class('form-control')
                        ->id('company_ceo_name')
                        ->placeholder(__('validation.attributes.frontend.company.ceo_name'))
                        ->attribute('maxlength', 191)
                        ->required() }}
                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->

        <div class="row">
            <div class="col">
                <div class="form-group">
                    {{ html()->label(__('validation.attributes.frontend.company.ceo_name_genetive'))->for('company_ceo_name_genetive') }}

                    {{ html()->text(config('teamwork.extra_field_name').'['.$type.'][company_ceo_name_genetive]', $profile['company_ceo_name_genetive']??'')
                        ->class('form-control')
                        ->id('company_ceo_name_genetive')
                        ->placeholder(__('validation.attributes.frontend.company.ceo_name_genetive'))
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
            <div class="col">
                <div class="form-group">
                    {{ html()->label(__('validation.attributes.frontend.company.real_address'))->for('company_real_address') }}

                    {{ html()->text(config('teamwork.extra_field_name').'['.$type.'][company_real_address]', $profile['company_real_address']??'')
                        ->class('form-control')
                        ->id('company_real_address')
                        ->placeholder(__('validation.attributes.frontend.company.real_address'))
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
            <div class="col-12 col-md-6">
                <div class="form-group">
                    Банк

                    {{ html()->text(config('teamwork.extra_field_name').'['.$type.'][company_bankname]', $profile['company_bankname']??'')
                        ->class('form-control')
                        ->id('company_bankname')
                        ->placeholder(__('validation.attributes.frontend.company.bankname'))
                        ->attribute('maxlength', 191)
                        ->required()}}
                </div><!--form-group-->
            </div><!--row-->

            <div class="col-12 col-md-6">
                <div class="form-group">
                    Счёт

                    {{ html()->text(config('teamwork.extra_field_name').'['.$type.'][company_bankaccount]', $profile['company_bankaccount']??'')
                        ->class('form-control')
                        ->id('company_bankaccount')
                        ->placeholder(__('validation.attributes.frontend.company.bankaccount'))
                        ->attribute('maxlength', 191)
                        ->required()}}
                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    Коррсчёт банка

                    {{ html()->text(config('teamwork.extra_field_name').'['.$type.'][company_bankcorr]', $profile['company_bankcorr']??'')
                        ->class('form-control')
                        ->id('company_bankcorr')
                        ->placeholder(__('validation.attributes.frontend.company.bankcorr'))
                        ->attribute('maxlength', 191)
                        ->required()}}
                </div><!--form-group-->
            </div><!--row-->

            <div class="col-12 col-md-6">
                <div class="form-group">
                    КПП банка

                    {{ html()->text(config('teamwork.extra_field_name').'['.$type.'][company_bankkpp]', $profile['company_bankkpp']??'')
                        ->class('form-control')
                        ->id('company_bankkpp')
                        ->placeholder(__('validation.attributes.frontend.company.bankkpp'))
                        ->attribute('maxlength', 191)
                        ->required()}}
                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    {{ html()->label(__('validation.attributes.frontend.company.bik'))->for('company_bik') }}

                    {{ html()->text(config('teamwork.extra_field_name').'['.$type.'][company_bik]', $profile['company_bik']??'')
                        ->class('form-control')
                        ->id('company_bik')
                        ->placeholder(__('validation.attributes.frontend.company.bik'))
                        ->attribute('maxlength', 191)
                        ->required()}}
                </div><!--form-group-->
            </div><!--col-->

            <div class="col-12 col-md-6">
                <div class="form-group">
                    {{ html()->label(__('validation.attributes.frontend.company.okpo'))->for('company_okpo') }}

                    {{ html()->text(config('teamwork.extra_field_name').'['.$type.'][company_okpo]', $profile['company_okpo']??'')
                        ->class('form-control')
                        ->id('company_okpo')
                        ->placeholder(__('validation.attributes.frontend.company.okpo'))
                        ->attribute('maxlength', 191)
                        ->required()}}
                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    {{ html()->label(__('validation.attributes.frontend.company.okved'))->for('company_okved') }}

                    {{ html()->text(config('teamwork.extra_field_name').'['.$type.'][company_okved]', $profile['company_okved']??'')
                        ->class('form-control')
                        ->id('company_okved')
                        ->placeholder(__('validation.attributes.frontend.company.okved'))
                        ->attribute('maxlength', 191)
                        ->required()}}
                </div><!--form-group-->
            </div><!--col-->

            <div class="col-12 col-md-6">
                <div class="form-group">
                    {{ html()->label(__('validation.attributes.frontend.company.ogrn'))->for('company_okpo') }}

                    {{ html()->text(config('teamwork.extra_field_name').'['.$type.'][company_ogrn]', $profile['company_ogrn']??'')
                        ->class('form-control')
                        ->id('company_ogrn')
                        ->placeholder(__('validation.attributes.frontend.company.ogrn'))
                        ->attribute('maxlength', 191)
                        ->required()}}
                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    {{ html()->label(__('validation.attributes.frontend.company.manager'))->for('company_manager') }}

                    {{ html()->text(config('teamwork.extra_field_name').'['.$type.'][company_manager]', $profile['company_manager']??'')
                        ->class('form-control')
                        ->id('company_manager')
                        ->placeholder(__('validation.attributes.frontend.company.manager'))
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