@extends('backend.layouts.app')

@section('title', __('labels.backend.access.teams.management') . ' | ' . __('labels.backend.access.teams.edit'))

@section('breadcrumb-links')
    @include('backend.auth.team.includes.breadcrumb-links')
@endsection

@section('content')

    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        @lang('labels.backend.access.teams.edit')
                        <small class="text-muted">{{ $team->name }}</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->
            <!--row-->

            {{ html()->modelForm($team, 'PATCH', route('admin.auth.team.update', $team))->class('form-horizontal')->open() }}

            <hr />

            <div class="form-group row">
                <div class="col-sm-12">
                    <h5 class="text-muted mb-4">@lang('labels.backend.access.teams.roles')</h5>
                </div><!--col-->
                @if($roles->count())
                    @foreach($roles as $role)
                        <div class="col-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="checkbox d-flex align-items-center">
                                        {{ html()->label(
                                                html()->radio('roles[]', in_array($role->name, $teamRoles), $role->name)
                                                        ->class('switch-input')
                                                        ->id('role-'.$role->id)
                                                . '<span class="switch-slider" data-checked="on" data-unchecked="off"></span>')
                                            ->class('switch switch-label switch-pill switch-primary mr-2')
                                            ->for('role-'.$role->id) }}
                                        {{ html()->label(ucwords($role->name))->for('role-'.$role->id) }}
                                    </div>
                                </div>
                            </div><!--card-->
                        </div><!--col-->
                    @endforeach
                @endif
            </div><!--form-group-->

            @if($operators->count())
            <hr />

            <div class="form-group row">
                <div class="col-sm-12">
                    <h5 class="text-muted mb-4">@lang('labels.backend.access.teams.subscriptions')</h5>
                </div><!--col-->

                    @foreach($operators as $operator)
                        <div class="col-4">
                            <div class="card">
                                <div class="card-header">
                                    <div class="checkbox d-flex align-items-center">
                                        {{ html()->label(
                                                html()->checkbox('subscriptions[]', in_array($operator->id, $teamSubscriptions), $operator->id)
                                                        ->class('switch-input')
                                                        ->id('subscription-'.$operator->id)
                                                . '<span class="switch-slider" data-checked="on" data-unchecked="off"></span>')
                                            ->class('switch switch-label switch-pill switch-primary mr-2')
                                            ->for('subscription-'.$operator->id) }}
                                        {{ html()->label(ucwords($operator->name))->for('subscription-'.$operator->id) }}
                                    </div>
                                </div>
                            </div><!--card-->
                        </div><!--col-->
                    @endforeach
            </div><!--form-group-->
            @endif

            </div><!--/card-body-->

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

        {{ html()->closeModelForm() }}


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