@extends('frontend.layouts.app')

@section('content')
<v-container fluid grid-list-md text-xs-center>
  <v-row justify="center">
    <v-col cols="12">
      <v-card>
        <v-toolbar dark color="#66a5ae">
          <v-card-title>
            @lang('labels.frontend.tours.'.$model_alias.'.edit')
          </v-card-title>
        </v-toolbar>
        @include('frontend.tour.tour.includes.edit-form')
      </v-card>
    </v-col>
  </v-row>
</v-container>
@endsection