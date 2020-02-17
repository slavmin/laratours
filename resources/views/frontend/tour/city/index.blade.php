@extends('frontend.layouts.app')

@section('content')
<v-container fluid grid-list-md text-xs-center>
  <h1 class="text-white text-center">
    @lang('labels.frontend.tours.city.management')
  </h1>
  <h2 class="text-white text-center">
    <v-btn text dark href="{{ route('frontend.tour.country.index') }}" class="tc-link-no-underline-on-hover">
      <v-icon>
        arrow_left
      </v-icon>
      @lang('labels.frontend.tours.country.management')
    </v-btn>
    {{ $country->name }}
  </h2>


  <v-row justify="center">
    <v-btn fab dark class="tc-red-bg tc-link-no-underline-on-hover" title="@lang('buttons.general.crud.create')"
      href="{{ route('frontend.tour.city.create', $country->id) }}">
      <i class="material-icons">
        add
      </i>
    </v-btn>
  </v-row>
  <v-row>
    <v-col>
      <v-card>
        <v-toolbar prominent dark color="#94CED7" src="/img/frontend/cities_tmpl.jpg"></v-toolbar>
        @if (count($items)>0)
        <v-simple-table class="mt-5">
          <template v-slot:default>
            <thead>
              <tr>
                <th class="text-left">
                  @lang('labels.frontend.tours.city.table.name')
                </th>
                <th class="text-left">
                  @lang('labels.frontend.tours.city.table.description')
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