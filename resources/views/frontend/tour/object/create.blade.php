@extends('frontend.layouts.app')

@section('content')
<v-container
  fluid
  grid-list-md
  text-xs-center
>
  <v-layout row wrap justify-center>
    <v-flex xs12>
      <v-card>
        <v-toolbar
          dark
          color="#66a5ae"
        >
          <v-btn 
            href="{{$cancel_route}}"
            class="tc-link-no-underline-on-hover"
            title="{{__('buttons.general.cancel')}}"
            icon 
            text
          >
            <v-icon>close</v-icon>
          </v-btn>
          <v-spacer></v-spacer>
          <v-card-title class="display-1">
            @lang('labels.frontend.tours.'.$model_alias.'.create')
          </v-card-title>
        </v-toolbar>
        <v-card-text>
          @include('frontend.tour.object.includes.'.$model_alias.'.form')
        </v-card-text>
      </v-card>
    </v-flex>
  </v-layout>
</v-container>
@endsection
