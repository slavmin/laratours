@extends('frontend.layouts.app')

@section('content')
    <div class="col">
        <div class="table-responsive" style="min-height: 0">
            <table class="table" style="margin-bottom: 0">
                <tr>
                    <th>@lang('labels.backend.access.teams.tabs.content.overview.name')</th>
                    <td>{{ $logged_in_user->currentTeam->name }} </td>
                </tr>

                <tr>
                    <th>@lang('labels.backend.access.teams.table.number_of_users')</th>
                    <td>{{ $logged_in_user->currentTeam->users->count() }}</td>
                </tr>

                <tr>
                    <th colspan="2">@lang('labels.backend.access.teams.tabs.content.overview.members')</th>
                </tr>

            </table>
        </div><!--table-responsive-->
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
                                <h5 class="mt-0 mb-1 user-name">{{$user->name}}</h5>
                                <div class="mb-0 user-mail">{{$user->email}}</div>
                                @if($user->isOwnerOfTeam($logged_in_user->currentTeam->id))
                                    <div><strong>@lang('labels.backend.access.teams.table.owner')</strong></div>
                                @else
                                <div class="user-button-group position-absolute"
                                     style="top: 0; right: 0">

                                    <form style="display: inline-block;"
                                          action="{{route('frontend.user.team.members.destroy', [$user->id])}}"
                                          method="post">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_method" value="DELETE"/>
                                        <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i>
                                            Delete
                                        </button>
                                    </form>

                                @endif
                                </div>
                            </div>
                        </li>
                @endforeach
            </ul>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Pending invitations</h1>
                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        <th>E-Mail</th>
                        <th colspan="2">Action</th>
                    </tr>
                    </thead>
                    @foreach($logged_in_user->currentTeam->invites as $invite)
                        <tr>
                            <td>{{$invite->email}}</td>
                            <td>
                                <a href="{{route('frontend.user.team.resend_invite', $invite)}}"
                                   class="btn btn-sm btn-primary">
                                    <i class="fa fa-envelope-o"></i> Resend invite
                                </a>
                            </td>
                            <td>
                                <a href="{{route('frontend.user.team.delete_invite', $invite)}}"
                                   class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash-o"></i> Delete invite
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Invite to team "{{$logged_in_user->currentTeam->name}}"</h4>
                <form class="form-horizontal" method="post"
                      action="{{ route('frontend.user.team.invite', $logged_in_user->currentTeam->id) }}">
                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="control-label">E-Mail Address</label>

                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                        @if ($errors->has('email'))
                            <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                        @endif

                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fa fa-btn fa-envelope-o"></i> Invite to Team
                        </button>
                    </div>
            </div>
            </form>
        </div>
    </div><!--col-->
@endsection