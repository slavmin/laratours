@extends('frontend.layouts.app')

@section('content')

    {{-- @include('frontend.tour.includes.city-select-form') --}}
    <v-container
      fluid
      grid-list-md
      text-xs-center
    >
      <h1 class="text-white text-center">
        @lang('labels.frontend.tours.'.$model_alias.'.management')
      </h1>
      <v-layout
        row
        wrap
        justify-center
        mb-5
      >
        <v-btn 
          fab
          dark 
          class="tc-red-bg tc-link-no-underline-on-hover"
          title="@lang('buttons.general.crud.create')"
          href="{{ route('frontend.tour.'.$model_alias.'.create', $city_param) }}"
        >
          <i class="material-icons">
            add
          </i>
        </v-btn>
      </v-layout>
      <v-layout
        row
        wrap
      >
        @if(count($items)>0)
          @foreach($items as $item)
          <v-flex
            mb-5
            xs12
            md12
            lg6
            xl4
          >
            <v-card
              class="mx-auto"
              max-width="100%"
              outlined
            >
            <v-img
              class="white--text align-end"
              height="200px"
              src="/img/frontend/ermitage.jpg"
            >
              <v-card-title></v-card-title>
            </v-img>
            <v-list-item three-line>
              <v-list-item-content>
                <div class="overline mb-4">тип музея</div>
                <v-list-item-title class="headline mb-1">
                  <v-layout row wrap justify-space-between>
                  <v-flex>{{$item->name}}</v-flex>
                  {!! $item->action_buttons !!}
                  </v-layout>
                </v-list-item-title>
                <v-list-item-subtitle>
                  @if (array_key_exists($item->city_id, $cities_names))
                    <div class="text-secondary">
                      Город: {{$cities_names[$item->city_id]}}
                    </div>
                    <div class="text-secondary">
                      Адрес: {{ $item->address }}
                    </div>
                  @endif
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>

            <v-card-actions>
              <v-btn text>Button</v-btn>
              <v-btn text>Button</v-btn>
            </v-card-actions>
          </v-card>
          </v-flex>
          @endforeach
        @endif
      </v-layout>
    </v-container>
    {{-- {{dd($items)}} --}}
    
    {{--<div class="card mb-4">
        <div class="card-body">
             <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="text-info mb-0 mr-1">@lang('labels.frontend.tours.'.$model_alias.'.management')</h6>
                        <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                             
                        </div><!-- btn-toolbar -->
                    </div>
                </div><!--col-->
            </div><!--row -->
            
            <div class="row mt-4">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>@lang('labels.frontend.tours.'.$model_alias.'.table.name')</th>
                                <th>@lang('labels.frontend.tours.tour.city')</th>
                                <th>@lang('labels.frontend.tours.'.$model_alias.'.table.qnt')</th>
                                <th><div class="float-right">@lang('labels.general.actions')</div></th>
                            </tr>
                            </thead>
                            <tbody>
                                    
                            </tbody>
                        </table>
                    </div>
                </div><!-- col -->
            </div><!-- row -->
            @endif

        </div><!--card-body-->
    </div><!--card--> --}}

    @include('frontend.tour.includes.pagination-row')

    @include('frontend.tour.includes.trash-bin')

@endsection