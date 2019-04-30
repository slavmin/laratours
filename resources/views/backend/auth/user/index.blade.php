@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ __('labels.backend.access.users.management') }}
                        <small class="text-muted">{{ __('labels.backend.access.users.active') }}</small>
                    </h4>
                </div><!--col-->

                <div class="col-sm-7">
                    @include('backend.auth.user.includes.header-buttons')
                </div><!--col-->
            </div><!--row-->

            <div class="row mt-4">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>@lang('labels.backend.access.users.table.first_name')
                                    \ @lang('labels.backend.access.users.table.email')</th>
                                <th>@lang('labels.backend.access.users.table.team')</th>
                                <th>@lang('labels.backend.access.users.table.confirmed')</th>
                                <th>@lang('labels.backend.access.users.table.roles')
                                    \ @lang('labels.backend.access.users.table.permissions')</th>
                                <th>@lang('labels.backend.access.users.table.activated')</th>
                            <!--<th>@lang('labels.backend.access.users.table.social')</th>-->
                                <th>@lang('labels.backend.access.users.table.last_updated')</th>
                                <th>@lang('labels.general.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="mb-1">{{ $user->full_name }}</div>
                                        <div class="mb-1">{{ $user->email }}</div>
                                    </td>
                                    <td>
                                        @forelse($user->teams as $team)
                                            <div class="mb-2">
                                                <a href="{{route('admin.auth.team.show', $team->id)}}"
                                                   class="btn btn-info btn-sm">{{$team->name}}</a>
                                            </div>
                                        @empty
                                            <div class="mb-2">
                                                N/A
                                            </div>
                                        @endforelse
                                    </td>
                                    <td>{!! $user->confirmed_label !!}</td>
                                    <td>
                                        <div class="mb-1">{!! $user->roles_label !!}</div>
                                        <div class="mb-1">{!! $user->permissions_label !!}</div>
                                    </td>
                                    <td>{!! $user->status_label !!}</td>
                                <!--<td>{!! $user->social_buttons !!}</td>-->
                                    <td>{{ $user->updated_at->diffForHumans() }}</td>
                                    <td>{!! $user->action_buttons !!}</td>
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
                        {!! $users->total() !!} {{ trans_choice('labels.backend.access.users.table.total', $users->total()) }}
                    </div>
                </div><!--col-->

                <div class="col-5">
                    <div class="float-right">
                        {!! $users->render() !!}
                    </div>
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->
    </div><!--card-->
@endsection
