@push('after-scripts')
<script>
  function showExtraRow(id) {
    const extraRow = document.getElementById(`extra-row-${id}`)
    extraRow.classList.toggle('d-none') 
  }
</script>
@endpush
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
                  #
                </th>
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
                <th>
                  @lang('labels.frontend.tours.'.$model_alias.'.table.nights')
                </th>
                <th class="text-right">
                  @lang('labels.general.actions')
                </th>
              </tr>
            </thead>
            <tbody>
              @foreach($items as $item)
              <tr>
                <td class="grey--text" onclick="showExtraRow({{ $item->id }})">
                  {{ $item->id }}
                </td>
                <td class="title" onclick="showExtraRow({{ $item->id }})">
                  {{$item->name}}
                  @if(!$item->published)
                  <div class="overline red--text">не опубликован</div>
                  @endif
                </td>
                <td onclick="showExtraRow({{ $item->id }})">
                  @if (array_key_exists($item->tour_type_id, $tour_types))
                  {{$tour_types[$item->tour_type_id]}}
                  @endif
                  @if($item->tour_constructor_type_id == 2)
                  <span>(Тур от партнёра)</span>
                  @endif
                </td>
                <td onclick="showExtraRow({{ $item->id }})">
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
                <td onclick="showExtraRow({{ $item->id }})">{{$item->duration}}</td>
                <td onclick="showExtraRow({{ $item->id }})">{{$item->nights}}</td>
                <td>
                  <div class="float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                    {!! $item->action_buttons !!}
                  </div>
                </td>
              </tr>
              <tr id="{{ 'extra-row-'.$item->id }}" class="d-none">
                <td colspan="7">
                  доп инфа
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