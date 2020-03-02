{{-- {{ dd($item) }} --}}
<tour-edit method="{{ $method }}" route="{{ $route }}" token="{{ csrf_token() }}" :tour="{{ json_encode($item) }}"
  :tour-dates="{{ $item->dates }}" :countries-cities-options="{{ json_encode($countries_cities_options) }}"
  :tour-type-options-raw="{{ json_encode($tour_type_options) }}"
  :constructor-type-options="{{ json_encode($constructor_type_options) }}">
</tour-edit>