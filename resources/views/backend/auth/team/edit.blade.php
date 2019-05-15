@extends('backend.layouts.app')

@section('title', __('labels.backend.access.teams.management') . ' | ' . __('labels.backend.access.teams.edit'))

@section('breadcrumb-links')
    @include('backend.auth.team.includes.breadcrumb-links')
@endsection

@section('content')
{{--    {{ html()->modelForm($team, 'PATCH', route('admin.auth.team.update', $team))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        @lang('labels.backend.access.teams.management')
                        <small class="text-muted">@lang('labels.backend.access.teams.edit')</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->
            <!--row-->

            <hr />

            <div class="row mt-4">
                <div class="col">
                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.access.teams.name'))
                            ->class('col-md-2 form-control-label')
                            ->for('name') }}

                        <div class="col-md-10">
                            {{ html()->text('name')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.backend.access.teams.name'))
                                ->attribute('maxlength', 100)
                                ->required() }}
                        </div><!--col-->

                    </div><!--form-group-->
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.auth.team.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.update')) }}
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
    {{ html()->closeModelForm() }}--}}

    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        @lang('labels.backend.access.teams.management')
                        <small class="text-muted">@lang('labels.backend.access.teams.edit')</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->
            <!--row-->

        </div><!--/card-body-->
    </div><!--/card-->

    @if(count($profiles) > 0)
        @foreach($profiles as $type => $profile)

            <div class="card mb-4">

                <div class="card-header">
                    <strong>
                        @lang('labels.frontend.teams.profile')  {{ $type=='formal' ? 'юридические' : 'фактические' }}
                    </strong>
                </div><!--card-header-->

                <div class="card-body">

                    {{ html()->form('PATCH', route('admin.auth.team.update', $team->id))->open() }}

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
                </div><!-- card-body -->


                <div class="card-footer">
                    <div class="row">
                        <div class="col">
                            {{ form_cancel(route('admin.auth.team.index'), __('buttons.general.cancel')) }}
                        </div><!--col-->

                        <div class="col text-right">
                            {{ form_submit(__('buttons.general.crud.update')) }}
                        </div><!--col-->
                    </div><!--row-->
                </div><!--card-footer-->
            </div><!--card-->
            {{ html()->form()->close() }}

        @endforeach
    @endif


@endsection