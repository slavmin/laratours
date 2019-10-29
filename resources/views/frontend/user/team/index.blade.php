@extends('frontend.layouts.app')

@section('content')
    <div class="row">

      <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between py-3 border-bottom border-info">
                        <h6 class="text-secondary">@lang('labels.frontend.teams.table.name')</h6>
                        <div class="text-info"><strong>{{ $team->name }}</strong></div>
                    </div>

                    <div class="d-flex justify-content-between py-3 border-bottom border-info">
                        <h6 class="text-secondary">@lang('labels.frontend.teams.table.number_of_users')</h6>
                        <div>{{ $team->users->count() }} @lang('labels.frontend.teams.from') {{ config('teamwork.team_members_quota')  }}</div>
                    </div>

                    <div class="d-flex justify-content-between py-3">
                        <h6 class="text-secondary">@lang('labels.frontend.teams.table.members')</h6>
                    </div>

                    <div>
                        <ul class="list-unstyled">
                            @foreach($team->users as $user)
                                @if($user->isOwnerOfTeam($team->id))
                                    <li class="media team-owner mb-2 p-2 border border-light">
                                        <img src="{{ $user->avatar }}" class="mr-3" alt="...">
                                        <div class="media-body position-relative">
                                            <h5 class="mt-0 user-name text-secondary">{{$user->name}}</h5>
                                            <div class="mb-2 user-mail text-info">{{$user->email}}</div>
                                            <div><span class="text-success">@lang('labels.backend.access.teams.table.owner')</span></div>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                            @foreach($team->users as $user)
                                @if(!$user->isOwnerOfTeam($team->id))
                                    <li class="media team-member mb-2 p-2 border border-light">
                                        <img src="{{ $user->avatar }}" class="mr-3" alt="...">
                                        <div class="media-body position-relative">
                                            <h5 class="mt-0 user-name text-secondary">{{$user->name}}</h5>
                                            <div class="mb-2 user-mail text-info">{{$user->email}}</div>
                                            <div class="user-button-group position-absolute" style="top: 0; right: 0">
                                                <div class="user-button-group position-absolute"
                                                     style="top: 0; right: 0">

                                                    <form style="display: inline-block;"
                                                          action="{{ route('frontend.user.team.members.destroy', $user->id) }}"
                                                          method="post">
                                                        {!! csrf_field() !!}
                                                        <input type="hidden" name="_method" value="DELETE"/>
                                                        <button class="btn btn-danger btn-sm" title="@lang('labels.general.buttons.delete')"><i
                                                                    class="far fa-trash-alt"></i>
                                                        </button>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div><!--/card-body-->
            </div><!--/card-->

      @isset($profiles)
          @foreach($profiles as $type => $profile)

            <div class="list-group mb-4">
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="text-info mb-0 mr-1">@lang('labels.frontend.teams.profile')   @isset($type){{ $type=='formal' ? 'юридические' : 'фактические' }}@endisset</h6>
                        <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                            <a href="{{ route('frontend.user.team.edit') }}" class="btn btn-outline-info ml-1" data-toggle="tooltip" title="@lang('labels.general.buttons.update')">
                                <i class="fas fa-edit"></i></a>
                        </div><!--btn-toolbar-->
                    </div>
                </div>

                        <div class="list-group-item">
                            <span class="text-secondary">@lang('validation.attributes.frontend.company.name') :</span> {{ $profile['company_name']??'' }}</div>
                        <div class="list-group-item">
                            <span class="text-secondary">@lang('validation.attributes.frontend.company.phone') :</span> {{ $profile['company_phone']??'' }}</div>
                        <div class="list-group-item">
                            <span class="text-secondary">@lang('validation.attributes.frontend.company.email') :</span> {{ $profile['company_email']??'' }}</div>
                        <div class="list-group-item">
                            <span class="text-secondary">@lang('validation.attributes.frontend.company.country') :</span> {{ $profile['company_country']??'' }}</div>
                        <div class="list-group-item">
                            <span class="text-secondary">@lang('validation.attributes.frontend.company.city') :</span> {{ $profile['company_city']??'' }}</div>
                        <div class="list-group-item">
                            <span class="text-secondary">@lang('validation.attributes.frontend.company.address') :</span> {{ $profile['company_address']??'' }}</div>
                        <div class="list-group-item">
                            <span class="text-secondary">@lang('validation.attributes.frontend.company.inn') :</span> {{ $profile['company_inn']??'' }}</div>
                        <div class="list-group-item">
                            <span class="text-secondary">@lang('validation.attributes.frontend.company.kpp') :</span> {{ $profile['company_kpp']??'' }}</div>
                        <div class="list-group-item">
                            <span class="text-secondary">Банк :</span> {{ $profile['company_bankname']??'' }}</div>
                        <div class="list-group-item">
                            <span class="text-secondary">Счет :</span> {{ $profile['company_bankaccount']??'' }}</div>
                        <div class="list-group-item">
                            <span class="text-secondary">Коррсчет банка :</span> {{ $profile['company_bankcorr']??'' }}</div>
                        <div class="list-group-item">
                            <span class="text-secondary">КПП :</span> {{ $profile['company_bankkpp']??'' }}</div>
            
            </div><!--/list-group-->

          @endforeach
      @endisset


      </div><!--/col-lg-8-->

      <div class="col-lg-4">

            @if($team->users->count() < config('teamwork.team_members_quota'))

                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-title text-info mb-3 py-1">@lang('labels.frontend.teams.invite_member')</h6>

                        {{ html()->form('POST', route('frontend.user.team.invite', $team->id))->class('form-horizontal')->open() }}
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{--{{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}--}}

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

            @endif


            @if($team->invites->count())

                <div class="list-group mb-4">
                    <h6 class="list-group-item text-info py-4">@lang('labels.frontend.teams.invites_send')</h6>

                    @foreach($team->invites as $invite)
                        <div class="d-flex justify-content-between py-3 list-group-item">
                            <div class="email-send">{{ $invite->email }}</div>

                            <div class="btn-group btn-group-sm" role="group" aria-label="action buttons">
                                <a href="{{ route('frontend.user.team.resend_invite', $invite) }}"
                                   class="btn btn-info" title="@lang('labels.general.buttons.send')">
                                    <i class="fas fa-sync"></i>
                                </a>
                                <a href="{{ route('frontend.user.team.delete_invite', $invite) }}"
                                   class="btn btn-danger" title="@lang('labels.general.buttons.delete')">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </div>

                        </div>
                    @endforeach

                </div><!--/list-group-->

            @endif

            @if($team->subscribers->count())

                <div class="list-group mb-4">
                    <h6 class="list-group-item text-info py-3">@lang('labels.frontend.teams.subscribers')</h6>

                    @foreach($team->subscribers as $subscriber)
                        <div class="d-flex justify-content-between py-3 list-group-item">
                            <div class="email-send">{{ $subscriber->name }}</div>
                        </div>
                    @endforeach

                </div><!--/list-group-->

            @endif

            @if($team->subscriptions->count())

                <div class="list-group mb-4">
                    <h6 class="list-group-item text-info py-3">@lang('labels.frontend.teams.subscriptions')</h6>

                    @foreach($team->subscriptions as $subscription)
                        <div class="d-flex justify-content-between py-3 list-group-item">
                            <div class="email-send">{{ $subscription->name }}</div>
                        </div>
                    @endforeach

                </div><!--/list-group-->

            @endif

        </div><!--/col-lg-4-->

    </div><!--/row-->
@endsection