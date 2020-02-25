<tour-create method="{{ $method }}" route="{{ $route }}" token="{{ csrf_token() }}"
  :countries-cities-options="{{ json_encode($countries_cities_options) }}"
  :tour-type-options-raw="{{ json_encode($tour_type_options) }}"
  :constructor-type-options="{{ json_encode($constructor_type_options) }}">
</tour-create>