@lang('strings.emails.contact.email_body_title')

@lang('validation.attributes.frontend.name'): {{ $this->request['name'] }}
@lang('validation.attributes.frontend.email'): {{ $this->request['email'] }}
@lang('validation.attributes.frontend.phone'): {{ $this->request['phone'] ?? 'N/A' }}
@lang('validation.attributes.frontend.message'): {{ $this->request['message'] }}
