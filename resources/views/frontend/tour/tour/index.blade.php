@extends('frontend.layouts.app')

@section('content')

{{-- @include('frontend.tour.includes.city-type-select-form') --}}
<v-container fluid grid-list-md text-xs-center>
  <h1 class="text-white text-center">
    @lang('labels.frontend.tours.'.$model_alias.'.management')
  </h1>
  <v-row justify="center">
    <v-btn fab dark class="tc-red-bg tc-link-no-underline-on-hover" title="@lang('buttons.general.crud.create')"
      href="{{ route('frontend.tour.'.$model_alias.'.create') }}">
      <i class="material-icons">
        add
      </i>
    </v-btn>
  </v-row>
  <v-row>
    <v-col>
      <v-card>
        <v-toolbar prominent dark color="#94CED7" src="/img/frontend/tours_tmpl.jpg"></v-toolbar>
        @if (count($items)>0)
        <v-simple-table class="mt-5">
          <template v-slot:default>
            <thead>
              <tr>
                <th>
                  @lang('labels.frontend.tours.'.$model_alias.'.table.name')
                </th>
                <th>
                  @lang('labels.frontend.tours.'.$model_alias.'.table.type')
                </th>
                <th>
                  @lang('labels.frontend.tours.tour.city')
                </th>
                <th>
                  @lang('labels.frontend.tours.'.$model_alias.'.table.duration')
                </th>
                <th class="text-right">
                  @lang('labels.general.actions')
                </th>
              </tr>
            </thead>
            <tbody>
              @foreach($items as $item)
              <tr>
                <td>
                  {{$item->name}}
                </td>
                <td>
                  @if (array_key_exists($item->tour_type_id, $tour_types))
                  {{$tour_types[$item->tour_type_id]}}
                  @endif
                </td>
                <td>
                  @if(!is_null($item->cities_list))
                  @foreach($item->cities_list as $city)
                  @if (array_key_exists($city, $cities_names))
                  {{$cities_names[$city]}}
                  @endif
                  @endforeach
                  @else
                  N/A
                  @endif
                </td>
                <td>{{$item->duration}}</td>
                <td>
                  <div class="float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                    {!! $item->action_buttons !!}
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </template>
        </v-simple-table>
        @endif
      </v-card>
    </v-col>
  </v-row>
</v-container>
<div class="card mb-4">
  <div class="card-body">
    <div class="row">
      <div class="col">
        <div class="d-flex justify-content-between align-items-center">
          <h6 class="text-info mb-0 mr-1">@lang('labels.frontend.tours.'.$model_alias.'.management')</h6>
          <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
            <a href="" class="btn btn-success ml-1" data-toggle="tooltip" title="@lang('buttons.general.crud.create')">
              <i class="fas fa-plus"></i></a>
          </div>
          <!--btn-toolbar-->
        </div>
      </div>
      <!--col-->
    </div>
    <!--row-->

    @if(count($items)>0)
    <div class="row mt-4">
      <div class="col">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>

              </tr>
            </thead>
            <tbody>
              @foreach($items as $item)
              <tr>
                <td>{{$item->name}}</td>

                <td>
                  <div class="float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                    {!! $item->action_buttons !!}
                  </div>
                  <!--float-right-->
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <!--col-->
    </div>
    <!--row-->
    @endif

  </div>
  <!--card-body-->
</div>
<!--card-->

@include('frontend.tour.includes.pagination-row')

@include('frontend.tour.includes.trash-bin')

@endsection