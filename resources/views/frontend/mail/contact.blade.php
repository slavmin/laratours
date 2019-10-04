@component('mail::message')
 # @lang('strings.emails.contact.email_body_title')

 ** @lang('validation.attributes.frontend.name'): ** {{ $name }}

 ** @lang('validation.attributes.frontend.email'): ** {{ $email }}

 ** @lang('validation.attributes.frontend.phone'): ** {{ $phone ?? 'N/A' }}

 ** @lang('validation.attributes.frontend.message'): ** {{ $body }}

@endcomponent