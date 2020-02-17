@extends('frontend.layouts.app')

@section('content')
<v-container fluid grid-list-md text-xs-center>
  <h1 class="text-white text-center">
    @lang('labels.frontend.tours.country.management')
  </h1>
  <v-row justify="center">
    <v-btn fab dark class="tc-red-bg tc-link-no-underline-on-hover" title="@lang('buttons.general.crud.create')"
      href="{{ route('frontend.tour.country.create') }}">
      <i class="material-icons">
        add
      </i>
    </v-btn>
  </v-row>
  <v-row>
    <v-col>
      <v-card>
        <v-toolbar prominent dark color="#94CED7" src="/img/frontend/country_tmpl.jpg"></v-toolbar>
        @if (count($items)>0)
        <v-simple-table class="mt-5">
          <template v-slot:default>
            <thead>
              <tr>
                <th class="text-left">
                  @lang('labels.frontend.tours.country.table.name')
                </th>
                <th class="text-left">
                  @lang('labels.frontend.tours.hotel.category.table.description')
                </th>
                <th class="text-left">
                  @lang('labels.frontend.tours.country.table.cities_count')
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
                  {{$item->description}}
                </td>
                <td>
                  {{$item->cities_count}}
                  <v-btn text icon color="green" class="tc-link-no-underline-on-hover"
                    href="{{ route('frontend.tour.city.index', $item->id) }}">
                    <v-icon title="{{ __('buttons.tours.city_list') }}">
                      edit
                    </v-icon>
                  </v-btn>
                </td>
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

@include('frontend.tour.includes.pagination-row')

@include('frontend.tour.includes.trash-bin')

@endsection