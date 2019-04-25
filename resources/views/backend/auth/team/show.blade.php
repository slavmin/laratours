@extends('backend.layouts.app')


@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.view'))

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        @lang('labels.backend.access.teams.management')
                        <small class="text-muted">@lang('labels.backend.access.teams.view')</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <div class="row mt-4 mb-4">
                <div class="col">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-expanded="true"><i class="fas fa-users"></i> @lang('labels.backend.access.teams.tabs.titles.overview')</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="overview" role="tabpanel" aria-expanded="true">
                            @include('backend.auth.team.show.tabs.overview')
                        </div><!--tab-->
                    </div><!--tab-content-->
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    <small class="float-right text-muted">
                        <strong>@lang('labels.backend.access.teams.tabs.content.overview.created_at'):</strong> {{ timezone()->convertToLocal($team->created_at) }} ({{ $team->created_at->diffForHumans() }}),
                        <strong>@lang('labels.backend.access.teams.tabs.content.overview.last_updated'):</strong> {{ timezone()->convertToLocal($team->updated_at) }} ({{ $team->updated_at->diffForHumans() }})
                        @if($team->trashed())
                            <strong>@lang('labels.backend.access.teams.tabs.content.overview.deleted_at'):</strong> {{ timezone()->convertToLocal($team->deleted_at) }} ({{ $team->deleted_at->diffForHumans() }})
                        @endif
                    </small>
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
@endsection
