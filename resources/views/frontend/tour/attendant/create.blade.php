@extends('frontend.layouts.app')

@section('content')
<v-container fluid grid-list-md text-xs-center>
    <v-row>
        <v-col cols="12">
            <v-card>
                <v-toolbar dark color="#66a5ae">
                    <v-btn text href="{{ $cancel_route }}">
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-card-title>
                        @lang('labels.frontend.tours.attendant.create')
                    </v-card-title>
                </v-toolbar>
                <v-card-text>
                    @include('frontend.tour.includes.person-form')
                </v-card-text>
                <v-card-actions>
                    <v-btn text color="#aa282a" href="{{ $cancel_route }}">
                        {{ __('buttons.general.cancel') }}
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn form="form" type="submit" dark color="#aa282a">
                        {{ __('buttons.general.crud.update') }}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-col>
    </v-row>
    <v-row justify="center">
        <v-col xs="12">
            <h2 class="white--text text-center">Цены указываются непосредственно при создании тура.</h2>
        </v-col>
    </v-row>
</v-container>
@endsection