@extends('backend.layouts.app')

@section('title', __('labels.backend.access.teams.management') . ' | ' . __('labels.backend.access.teams.create'))

@section('breadcrumb-links')
    @include('backend.auth.team.includes.breadcrumb-links')
@endsection

@section('content')
    {{ html()->form('POST', route('admin.auth.team.store'))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        @lang('labels.backend.access.teams.management')
                        <small class="text-muted">@lang('labels.backend.access.teams.create')</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

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
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <hr>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <h5 class="text-muted mb-4">@lang('labels.backend.access.teams.roles')</h5>
                        </div><!--col-->
                        @if($roles->count())
                            @foreach($roles as $role)
                                <div class="col-2">
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
                                </div>
                            @endforeach
                        @endif
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
                    {{ form_submit(__('buttons.general.crud.create')) }}
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
    {{ html()->form()->close() }}
@endsection