<div class="col">
    <div>

        @isset($profiles)
            @foreach($profiles as $type => $profile)

                <div>
                    <div class="list-group list-group-flush mb-4">
                        <h6 class="list-group-item text-info py-4">@lang('labels.frontend.teams.profile')  {{ $type=='formal' ? 'юридические' : 'фактические' }}</h6>
                        @foreach($profile as $type => $field)
                            <div class="list-group-item">{{ $field }}</div>
                        @endforeach
                    </div><!--/list-group-->
                </div>

            @endforeach
        @endisset

    </div>
</div><!--col-->
