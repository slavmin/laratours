@component('mail::message')
# {{ $text  }}

@component('mail::button', ['url' => $accept_url])
{{ $accept_text  }}
@endcomponent

{{ $link_text }}

<br>

{{ config('app.name') }}
@endcomponent