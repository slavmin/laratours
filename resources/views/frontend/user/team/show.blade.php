@extends('frontend.layouts.app')

@section('content')
    <div class="d-flex">

      <div class="flex-grow-1">
          <div class="inlay pl-3 pr-3">

            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between py-3 border-bottom border-info">
                        <h6 class="text-secondary">@lang('labels.frontend.teams.table.name')</h6>
                        <div class="text-info"><strong>{{ $logged_in_user->currentTeam->name }}</strong></div>
                    </div>

                    <div class="d-flex justify-content-between py-3 border-bottom border-info">
                        <h6 class="text-secondary">@lang('labels.frontend.teams.table.number_of_users')</h6>
                        <div>{{ $logged_in_user->currentTeam->users->count() }} @lang('labels.frontend.teams.from') {{ config('teamwork.team_members_quota')  }}</div>
                    </div>

                    <div class="d-flex justify-content-between py-3">
                        <h6 class="text-secondary">@lang('labels.frontend.teams.table.members')</h6>
                    </div>

                    <div>
                        <ul class="list-unstyled">
                            @foreach($logged_in_user->currentTeam->users as $user)
                                @if($user->isOwnerOfTeam($logged_in_user->currentTeam->id))
                                    <li class="media team-owner mb-2 p-2 border border-light">
                                @else
                                    <li class="media team-member mb-2 p-2 border border-light">
                                        @endif
                                        <img src="{{ $user->avatar }}" class="mr-3" alt="...">
                                        <div class="media-body position-relative">
                                            <h6 class="mt-0 mb-2 user-name text-secondary">{{ $user->name }}</h6>
                                            <div class="mb-1 user-mail text-info">{{ $user->email }}</div>
                                            @if($user->isOwnerOfTeam($logged_in_user->currentTeam->id))
                                                <div><span class="text-success">@lang('labels.frontend.teams.table.owner')</span></div>
                                            @else
                                                <div class="user-button-group position-absolute"
                                                     style="top: 0; right: 0">

                                                    <form style="display: inline-block;"
                                                          action="{{ route('frontend.user.team.members.destroy', [$user->id]) }}"
                                                          method="post">
                                                        {!! csrf_field() !!}
                                                        <input type="hidden" name="_method" value="DELETE"/>
                                                        <button class="btn btn-danger btn-sm" title="@lang('labels.general.buttons.delete')"><i
                                                                    class="far fa-trash-alt"></i>
                                                        </button>
                                                    </form>

                                                </div>
                                            @endif
                                        </div>
                                    </li>
                            @endforeach
                        </ul>
                    </div>
                </div><!--/card-body-->
            </div><!--/card-->

          </div><!--/inlay-->
      </div><!--/flex-grow-1-->

      <div class="flex-shrink-1">

            @if($logged_in_user->currentTeam->users->count() < config('teamwork.team_members_quota'))
                <div class="inlay pl-2 pr-2">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="card-title text-info">Пригласить в "{{ $logged_in_user->currentTeam->name }}"</h6>

                            {{ html()->form('POST', route('frontend.user.team.invite', $logged_in_user->currentTeam->id))->class('form-horizontal')->open() }}

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}

                                        {{ html()->email('email')
                                            ->class('form-control')
                                            ->placeholder(__('validation.attributes.frontend.email'))
                                            ->attribute('maxlength', 191)
                                            ->value(old('email'))
                                            ->required() }}
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->

                            <div class="row">
                                <div class="col">
                                    <div class="form-group mb-0 clearfix">
                                        <button type="submit" class="btn btn-info btn-block">
                                            <i class="fas fa-envelope"></i> @lang('labels.general.buttons.send')
                                        </button>
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->

                            {{ html()->form()->close() }}

                        </div><!--/card-body-->
                    </div><!--/card-->
                </div><!--/inlay-->
            @endif


            @if($logged_in_user->currentTeam->invites->count() > 0)
                <div class="inlay pl-2 pr-2">
                    <div class="card mb-5">
                        <div class="card-body">
                            <h6 class="card-title text-info">Отправленные приглашения</h6>
                            @foreach($logged_in_user->currentTeam->invites as $invite)
                                <div class="d-flex justify-content-between py-3 border-bottom border-light">
                                    <div>{{ $invite->email }}</div>

                                    <div class="btn-group btn-group-sm" role="group" aria-label="action buttons">
                                        <a href="{{ route('frontend.user.team.resend_invite', $invite) }}"
                                           class="btn btn-info" title="@lang('labels.general.buttons.send')">
                                            <i class="fas fa-sync"></i> {{--@lang('labels.general.buttons.send')--}}
                                        </a>
                                        <a href="{{ route('frontend.user.team.delete_invite', $invite) }}"
                                           class="btn btn-danger" title="@lang('labels.general.buttons.delete')">
                                            <i class="far fa-trash-alt"></i> {{--@lang('labels.general.buttons.delete')--}}
                                        </a>
                                    </div>

                                </div>
                            @endforeach

                        </div><!--/card-body-->
                    </div><!--/card-->
                </div><!--/inlay-->
            @endif

        </div><!--/flex-shrink-1-->

    </div><!--/d-flex-->
@endsection