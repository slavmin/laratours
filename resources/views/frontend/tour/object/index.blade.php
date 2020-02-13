@extends('frontend.layouts.app')

@section('content')
<<<<<<< HEAD
    <h1 class="text-white text-center">
        @lang('labels.frontend.tours.'.$model_alias.'.management')
    </h1>
    @include('frontend.tour.includes.city-select-form')
    @include('frontend.tour.includes.pagination-row')

    {{-- <div class="container-xl">
        <div class="row">
            @foreach ($items as $item)
                <div class="col-lg-6 col-xs-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title">
                                {{ $item->name }}
                                <div class="float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                                    {!! $item->action_buttons !!}
                                </div>
                            </div>
                            <div class="card-text">
                                <p>{{ $cities_for_filter[$item->city_id] }}</p>
                                <table class="table">
                                    <thead>
                                        <th>Название</th>
                                        <th>Цены</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($item->objectables as $obj)
                                            <tr>
                                                <td>{{ $obj->name }}</td>
                                            </tr>
                                            <tr>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div> --}}
    
    <?php $scities = json_encode($cities_select); ?>
    @if ($model_alias == 'transport')
        <?php $sitems = json_encode($items); ?>
        <transport-index 
            :items="{{ $sitems }}"
            :cities="{{ $scities }}" 
            data-app
            token="{{ csrf_token() }}"
        ></transport-index>
    @endif
    @if ($model_alias == 'museum')
    <?php $sitems = json_encode($items); ?>
    <?php $scustomers = json_encode($customer_type_options_arrays); ?>
        <museum-index 
            data-app
            :items="{{ $sitems }}"
            :cities="{{ $scities }}" 
            :customers="{{ $scustomers }}"
            token="{{ csrf_token() }}"
        ></museum-index>
    @endif
    @if ($model_alias == 'hotel')
    <?php $sitems = json_encode($items); ?>
    <?php $scustomers = json_encode($customer_type_options); ?>
        <hotel-index 
            data-app
            :items="{{ $sitems }}"
            :customers="{{ $scustomers }}"
            token="{{ csrf_token() }}"
        ></hotel-index>
    @endif
    @if ($model_alias == 'meal')
    <?php $sitems = json_encode($items); ?>
        <meal-index 
            :items="{{ $sitems }}"
            data-app
            token="{{ csrf_token() }}"
        ></meal-index>
    @endif
=======
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
                src="{{ $item->getMedia('photos')->first() ? $item->getMedia('photos')->first()->getUrl() : '/img/frontend/museum_tmpl.jpg' }}"
              ></v-img>
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
                @if(count($item->objectables) > 0)
                <v-divider></v-divider>
                <div class="text-center mt-3">Экскурсии:</div>
                <v-simple-table dense>
                  <template v-slot:default>
                    <thead>
                      <tr>
                        <th class="text-left">Название</th>
                        <th class="text-center">Заказ-наряд</th>
                        <th class="text-center">Доп</th>
                        <th class="text-left">Цены</th>
                        <th class="text-right">Действия</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($item->objectables as $event)
                      <tr>
                        <td>{{ $event->name }}</td>
                        <td class="text-center">
                          @if(isset(json_decode($event->extra)->isCustomOrder))
                          <v-icon>
                            check
                          </v-icon>
                          @endif
                        </td>
                        <td class="text-center">
                          @if(isset(json_decode($event->extra)->isExtra) && json_decode($event->extra)->isExtra)
                          <v-icon>
                            check
                          </v-icon>
                          @endif
                        </td>
                        <td>
                          <v-btn
                            icon
                            href="{{ route('frontend.tour.attribute.edit', $event->id) }}"
                          >
                            <svg
                              style="width:24px;height:24px"
                              viewBox="0 0 24 24"
                            >
                              <path
                                fill="currentColor"
                                d="M5,6H23V18H5V6M14,9A3,3 0 0,1 17,12A3,3 0 0,1 14,15A3,3 0 0,1 11,12A3,3 0 0,1 14,9M9,8A2,2 0 0,1 7,10V14A2,2 0 0,1 9,16H19A2,2 0 0,1 21,14V10A2,2 0 0,1 19,8H9M1,10H3V20H19V22H1V10Z"
                              />
                            </svg>
                          </v-btn>
                        </td>
                        <td>
                          <v-row>
                            <v-spacer></v-spacer>
                            <museum-objectable
                              edit-mode
                              :museum="{{ $item }}"
                              :event="{{ $event }}"
                              :event-prices="{{ $event->priceable }}"
                              token="{{ csrf_token() }}"
                              :customers="{{ json_encode($customer_type_options_arrays) }}"
                            ></museum-objectable>
                            {{ html()
                              ->form('DELETE', route('frontend.tour.attribute.destroy', $event->id))
                              ->open() }}
                              <v-btn 
                                icon 
                                small 
                                color="red" 
                                type="submit"
                                title="{{ 'Удалить "'. $event->name .'"' }}"
                              >
                                <v-icon>close</v-icon>
                              </v-btn>
                            {{ html()->form()->close() }}
                          </v-row>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </template>
                </v-simple-table>
                @endif
              </v-list-item-content>
            </v-list-item>

            <v-card-actions>
              <v-spacer></v-spacer>
              <museum-objectable
                :museum="{{ $item }}"
                :customers="{{ json_encode($customer_type_options_arrays) }}"
                token="{{ csrf_token() }}"
              ></museum-objectable>
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
>>>>>>> dropjs

    @include('frontend.tour.includes.trash-bin')

@endsection