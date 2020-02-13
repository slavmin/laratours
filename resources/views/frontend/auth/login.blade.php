@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.auth.login_box_title'))

@section('content')
  <v-row justify="center">
    <v-card outlined class="mt-5">
      <v-toolbar
        dark
        prominent
        color="#94CED7"
        src="/img/frontend/login-card-header.jpg"
      >
        <v-card-title>
          @lang('labels.frontend.auth.login_box_title')
        </v-card-title>
      </v-toolbar>
      <v-list-item three-line>
        <v-list-item-content>
          <div class="overline mb-4">Введите email и пароль</div>
          <v-list-item-title class="headline mb-1 pt-2">
            {{ html()->form('POST', route('frontend.auth.login.post'))->id('login-form')->open() }}
            {{-- <v-form
              id="login-form"
              action="{{ route('frontend.auth.login.post') }}"
            > --}}
              <v-text-field
                name="email"
                type="email"
                label="{{ __('validation.attributes.frontend.email') }}"
                value="{{ $item->name ?? '' }}"
                maxlength="191"
                outlined
                required
              ></v-text-field>  
              <v-text-field
                name="password"
                type="password"
                label="{{ __('validation.attributes.frontend.password') }}"
                value="{{ $item->name ?? '' }}"
                maxlength="191"
                outlined
                required
              ></v-text-field>  
              {{-- {{ html()->label(html()->checkbox('remember', true, 1) . ' ' . __('labels.frontend.auth.remember_me'))->for('remember') }} --}}
              {{ html()->form()->close() }}
            </v-form>    
          </v-list-item-title>  
        </v-list-item-content>
      </v-list-item>
  
      <v-card-actions>
        <v-btn
          text
          color="#263B7A"
          href="{{ route('frontend.auth.password.reset') }}"
        >
          @lang('labels.frontend.passwords.forgot_password')
        </v-btn>
        <v-spacer></v-spacer>
        <v-btn 
          form="login-form"
          type="submit"
          class="ma-2" 
          tile 
          color="#aa282a" 
          dark
        >
          {{ __('labels.frontend.auth.login_button') }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-row>
@endsection
