<div class="col">
    <div>

        @isset($profiles)
            @foreach($profiles as $type => $profile)

                <div>
                    <div class="list-group list-group-flush mb-4">
                        <h6 class="list-group-item text-info py-4">@lang('labels.frontend.teams.profile')  {{ $type=='formal' ? 'юридические' : 'фактические' }}</h6>
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
                            <span class="text-secondary">@lang('validation.attributes.frontend.company.company_type') :</span> {{ $profile['company_type']??'' }}</div>
                    </div><!--/list-group-->
                </div>

            @endforeach
        @endisset

    </div>
</div><!--col-->
