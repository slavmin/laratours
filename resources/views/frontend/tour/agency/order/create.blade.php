@extends('frontend.layouts.app')
@section('content')
<v-container fluid grid-list-md text-xs-center>
  <h1 class="text-white text-center">
    @lang('labels.frontend.tours.order.create')
  </h1>
  <v-row justify="center">
    <v-col xs="12">
      <v-card>
        <v-toolbar prominent dark color="#94CED7" src="/img/frontend/order-card-header-gradient.jpg">
          <v-btn href="{{ $cancel_route }}" class="tc-link-no-underline-on-hover"
            title="{{__('buttons.general.cancel')}}" icon text>
            <v-icon>close</v-icon>
          </v-btn>
          <v-spacer></v-spacer>
          <v-toolbar-title>
            <h2 class="text-white text-center">
              <span class="font-weight-light">
                @lang('labels.frontend.tours.tour.name'):
              </span>
              {{ $tour->name }}
            </h2>
          </v-toolbar-title>
          @include('frontend.tour.agency.order.hint')
        </v-toolbar>
        </v-card-title>
        <v-card-text id="order">
          {{ html()
            ->form($method, $route)
            ->id('form')
            ->open() }}
          {{ html()->hidden('tour_id')->value($tour->id??0) }}
          {{ html()->hidden('operator_id')->value($tour->team_id??0) }}
          <h3 class="text-grey text-center">
            Данные для связи по заказу
          </h3>
          <v-row>
            <v-col lg="4" cols="12">
              <v-text-field name="contact_name" color="#aa282a"
                label="{{ __('labels.frontend.user.profile.first_name') }}" value="{{ old('contact_name') ?? '' }}"
                maxlength="191" outlined required></v-text-field>
            </v-col>
            <v-col lg="4" cols="12">
              <v-text-field name="email" prepend-icon="email" color="#aa282a"
                label="{{ __('labels.frontend.user.profile.email') }}" value="{{ old('email') ?? '' }}" maxlength="191"
                outlined required></v-text-field>
            </v-col>
            <v-col lg="4" cols="12">
              <v-text-field name="phone" prepend-icon="phone" color="#aa282a"
                label="{{ __('labels.frontend.user.profile.phone') }}" value="{{ old('phone') ?? '' }}" maxlength="191"
                outlined required></v-text-field>
            </v-col>
          </v-row>
          <h3 class="text-grey text-center">
            Данные туристов
          </h3>
          <order-form @if (old()) :old="{{ json_encode(old()) }}" @endif :transport="{{ json_encode($tour_transport) }}"
            :profiles="{{ json_encode($tour->orderprofiles) }}" :tour-prices="{{ json_encode($tour_prices) }}"
            :customer-options="{{ json_encode($customer_options) }}">
          </order-form>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="#aa282a" dark type="submit">ok</v-btn>
          {{ html()->form()->close() }}
        </v-card-actions>
      </v-card>
</v-container>
@endsection