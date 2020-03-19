@extends('frontend.layouts.app')

@section('content')
<v-container fluid grid-list-md text-xs-center>
  <h1 class="text-white text-center">
    <span>{{ $tour_object->name }}</span>:
    <span class="font-weight-light">{{ $item->name }}</span>
  </h1>
  <v-row justify="center">
    <v-col xs="12">
      <v-card>
        <v-toolbar prominent dark color="#94CED7" src="/img/frontend/prices-card-header-gradient.jpg">
          <v-btn href="{{ $cancel_route }}" class="tc-link-no-underline-on-hover"
            title="{{__('buttons.general.cancel')}}" icon text>
            <v-icon>close</v-icon>
          </v-btn>
          <v-spacer></v-spacer>
          <v-card-title class="display-2 font-weight-light">
            Цены и периоды
          </v-card-title>
        </v-toolbar>
        <object-attribute-price object-model="{{ $tour_object->model_alias }}"
          :price-type-options="{{ json_encode($price_type_options) }}" cancel-route="{{ $cancel_route }}"
          :price-types-for-view="{{ json_encode($price_types_for_view) }}" parent-id="{{ $item->id }}"
          parent-model="{{ $item->model_alias }}" :customers="{{ json_encode($customer_type_options) }}"
          token="{{ csrf_token() }}" :item="{{ json_encode($item) }}"></object-attribute-price>
        {{-- <v-card-actions>
          <v-btn href="{{ $cancel_route }}" class="tc-link-no-underline-on-hover"
        title="{{__('buttons.general.cancel')}}" text>Вернуться</v-btn>
        <v-spacer></v-spacer>
        <v-btn form="price-form" dark type="submit" color="#aa282a">
          Добавить
        </v-btn>
        </v-card-actions> --}}
      </v-card>
    </v-col>
  </v-row>
</v-container>
@endsection