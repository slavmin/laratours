{{-- {{ html()
  ->form($method, $route)
  ->id('form')
  ->class('form-horizontal')
  ->open() }} --}}
{{-- 'cities_options', 'countries_cities_options', 'tour_type_options', 'constructor_type_options' --}}
<tour-create method="{{ $method }}" route="{{ $route }}" token="{{ csrf_token() }}"
  :countries-cities-options="{{ json_encode($countries_cities_options) }}"
  {{-- :cities-options="{{ json_encode($cities_options) }}" --}}
  :tour-type-options-raw="{{ json_encode($tour_type_options) }}"
  :constructor-type-options="{{ json_encode($constructor_type_options) }}"></tour-create>
{{-- {{ html()->form()->close() }} --}}