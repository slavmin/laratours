<p>@lang('strings.emails.contact.email_body_title')</p>

<p><strong>@lang('validation.attributes.frontend.name'):</strong> {{ $this->request['name'] }}</p>
<p><strong>@lang('validation.attributes.frontend.email'):</strong> {{ $this->request['email'] }}</p>
<p><strong>@lang('validation.attributes.frontend.phone'):</strong> {{ $this->request['phone'] ?? 'N/A' }}</p>
<p><strong>@lang('validation.attributes.frontend.message'):</strong> {{ $this->request['message'] }}</p>
