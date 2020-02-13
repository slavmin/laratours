@extends('backend.layouts.app')

@section('title', app_name() . ' | '. __('labels.backend.access.teams.management'))

@section('breadcrumb-links')
    @include('backend.auth.team.includes.breadcrumb-links')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        @lang('labels.backend.access.teams.management')
                        <small class="text-muted">@lang('labels.backend.access.teams.active')</small>
                    </h4>
                </div><!--col-->
                
                <div class="col-sm-7 pull-right">
                    @include('backend.auth.team.includes.header-buttons')
                </div><!--col-->
            </div><!--row-->

            <div class="row mt-4">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>@lang('labels.backend.access.teams.table.team')</th>
                                <th>@lang('labels.backend.access.teams.table.role')</th>
                                <th>@lang('labels.backend.access.teams.table.owner')</th>
                                <th>@lang('labels.backend.access.teams.table.number_of_users')</th>
                                <th>@lang('labels.general.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($teams as $team)
                                <tr>
                                    <td>{{$team->name}}</td>
                                    <td><strong>{!! $team->roles_label !!}</strong></td>
                                    <td>
                                        @foreach($team->users as $user)
                                            @if($user->isOwnerOfTeam($team))
                                               {{$user->name}}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ $team->users->count() }}
                                    </td>
                                    <td>{!! $team->action_buttons !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!--col-->
            </div><!--row-->
            <div class="row">
                <div class="col-7">
                    <div class="float-left">
                        {!! $teams->total() !!} {{ trans_choice('labels.backend.access.teams.table.total', $teams->total()) }}
                    </div>
                </div><!--col-->

                <div class="col-5">
                    <div class="float-right">
                        {!! $teams->render() !!}
                    </div>
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->
    </div><!--card-->
@endsection
