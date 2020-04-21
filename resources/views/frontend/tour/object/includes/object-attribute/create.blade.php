@extends('frontend.layouts.app')

@section('content')
<v-container fluid grid-list-md text-xs-center>
    <v-row>
        <v-col xs="12">
            <v-card>
                <v-toolbar prominent dark color="#94CED7" src="/img/frontend/edit-object-card-header-gradient.jpg">
                    <v-btn href="{{ $cancel_route }}" class="tc-link-no-underline-on-hover"
                        title="{{__('buttons.general.cancel')}}" icon text>
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-toolbar-title class="display-2 font-weight-light">
                        {{ $tour_object->name }}
                    </v-toolbar-title>
                    <div>
                        Создание
                    </div>
                </v-toolbar>
                <{{ $parent_model_alias}}-objectable :tour-object="{{ $tour_object }}" token="{{ csrf_token() }}"
                    :customers="{{ json_encode($customer_type_options) }}">
                </{{ $parent_model_alias}}-objectable>
            </v-card>
        </v-col>
    </v-row>
    {{-- <v-row justify="center">
        <v-col xs="12">
            <v-card>
                <v-toolbar prominent dark color="#94CED7" src="/img/frontend/prices-card-header-gradient.jpg">
                    <v-spacer></v-spacer>
                    <v-card-title class="display-2 font-weight-light">
                        Цены и периоды
                    </v-card-title>
                </v-toolbar>
                <object-attribute-price object-model="{{ $parent_model_alias }}"
    :price-type-options="{{ json_encode($price_type_options) }}" cancel-route="{{ $cancel_route }}"
    :price-types-for-view="{{ json_encode($price_types_for_view) }}" parent-id="{{ $item->id ?? 0 }}"
    :customers="{{ json_encode($customer_type_options) }}" token="{{ csrf_token() }}"
    :item="{{ json_encode($item) }}"></object-attribute-price>
    </v-card>
    </v-col>
    </v-row> --}}
</v-container>
@endsection