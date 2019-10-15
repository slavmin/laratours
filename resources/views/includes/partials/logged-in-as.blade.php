@if(auth()->user() && session()->has("admin_user_id") && session()->has("temp_user_id"))
    <div class="alert alert-warning logged-in-as mb-0">
        @lang('strings.frontend.general.logged_in_as') {{ auth()->user()->name }}. <a href="{{ route("frontend.auth.logout-as") }}">@lang('strings.frontend.general.re_log_in_as') {{ session()->get("admin_user_name") }}</a>.
    </div><!--alert alert-warning logged-in-as-->
@endif
