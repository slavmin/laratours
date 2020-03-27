@extends('frontend.layouts.app')
@section('content')
<v-container fluid grid-list-md text-xs-center>
  <h1 class="text-white text-center">
    @lang('labels.frontend.tours.order.management')
  </h1>
  @if(count($items)>0)
  <v-row class="justify-center">
    <v-col>
      <v-card>
        <table class="tc-order-table">
          <thead>
            <th>
              @lang('labels.frontend.tours.tour.management')
            </th>
            <th>
              @lang('labels.frontend.tours.tour.city')
            </th>
            <th>
              @lang('labels.frontend.tours.tour.table.date')
            </th>
            <th>
              @lang('labels.frontend.tours.tour.table.duration')/
              @lang('labels.frontend.tours.tour.table.nights')
            </th>
            <th>
              @lang('labels.frontend.tours.tour.table.programm')
            </th>
            <th>
              @lang('labels.frontend.tours.tour.table.price')
            </th>
            <th>
              @lang('labels.frontend.tours.tour.table.actions')
            </th>
          </thead>
          <tbody>
            @foreach ($items as $item)
            <tr>
              <td>
                {{ $item->name }}
              </td>
              <td>
                {{ $cities_names[$item->city_id] }}
              </td>
              <td>
                {{ $item->start_date }}

              </td>
              <td>
                {{ $item->duration }}/
                {{ $item->nights }}
              </td>
              <td>
                {{-- <AboutTour :content="JSON.parse(item.extra).editorsContent" /> --}}
              </td>
              <td>
                от
                {{ $item->prices[0]->price }}
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-icon color="grey" v-on="on">
                      info
                    </v-icon>
                  </template>
                  <span>
                    Цена за одного взрослого при стандартном размещении.
                  </span>
                </v-tooltip>
              </td>
              <td>
                {!! $item->action_buttons !!}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </v-card>
    </v-col>
  </v-row>
  @endif
</v-container>
@include('frontend.tour.includes.pagination-row')
@include('frontend.tour.includes.agency-select-form')
@endsection