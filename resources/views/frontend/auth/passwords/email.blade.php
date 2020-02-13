@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.passwords.reset_password_box_title'))

@section('content')
  <v-row justify="center">
    <v-card outlined class="mt-5">
      <v-toolbar
        dark
        color="#94CED7"
      >
        <v-card-title>
          @lang('labels.frontend.passwords.reset_password_box_title')
        </v-card-title>
      </v-toolbar>
      <v-list-item class="mt-5">
        {{ html()->form('POST', route('frontend.auth.password.email.post'))->id('form')->open() }}
        <v-text-field
          name="email"
          type="email"
          label="{{ __('validation.attributes.frontend.email') }}"
          value="{{ $item->name ?? '' }}"
          maxlength="191"
          outlined
          required
        ></v-text-field> 
        {{ html()->form()->close() }}
      </v-list-item>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn 
          form="form"
          type="submit"
          class="ma-2" 
          tile 
          color="#aa282a" 
          dark
        >
          {{ __('labels.frontend.passwords.send_password_reset_link_button') }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-row>
  @if(session('status'))
  <v-row justify="center">
    <v-alert
      dense
      text
      type="success"
      class="mt-5"
      border="left"
      style="max-width: 350px;"
    >
    {{ session('status') }}
    </v-alert>
  </v-row>
  @endif
@endsection
