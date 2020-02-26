@extends('frontend.layouts.app')

@section('content')
<v-container fluid grid-list-md text-xs-center>
  <h1 class="text-white text-center">
    <span>{{ $tour_object->name }}</span>:
    <span class="font-weight-light">{{ $item->name }}</span>
  </h1>
  <v-row justify="center">
    <v-col xs="12">
      <v-card>
        <v-toolbar prominent dark color="#94CED7" src="/img/frontend/prices-card-header-gradient.jpg">
          <v-btn href="{{ $cancel_route }}" class="tc-link-no-underline-on-hover"
            title="{{__('buttons.general.cancel')}}" icon text>
            <v-icon>close</v-icon>
          </v-btn>
          <v-spacer></v-spacer>
          <v-card-title class="display-2 font-weight-light">
            Цены и периоды
          </v-card-title>
        </v-toolbar>
        @if (count($item->priceable) > 0)
        <v-simple-table>
          <template v-slot:default>
            <thead>
              <th>
                Начало периода
              </th>
              <th>
                Конец периода
              </th>
              <th>
                Тип
              </th>
              <th>
                Стоимость
              </th>
              <th>
                Действия
              </th>
            <tbody>
              @foreach ($item->priceable as $price)
              <tr>
                <td>
                  {{ $price->period_start }}
                </td>
                <td>
                  {{ $price->period_end }}
                </td>
                <td>
                  @if ($tour_object->model_alias != 'transport')
                  {{ $customer_type_options[$price->tour_customer_type_id] }}
                  @else
                  {{ $price_types_for_view[$price->tour_price_type_id] ?? '' }}
                  @endif
                </td>
                <td>
                  {{ $price->price }}
                </td>
                <td>
                  {{ html()
                          ->form('DELETE', route('frontend.tour.attribute-price.destroy', $price->id))
                          ->open() }}
                  <v-btn icon small color="red" type="submit" title="Удалить">
                    <v-icon>close</v-icon>
                  </v-btn>
                  {{ html()->form()->close() }}
                </td>
              </tr>
              @endforeach
            </tbody>
            </thead>
          </template>
        </v-simple-table>
        @else
        <v-row justify="center mt-5">
          <div class="display-1">
            Цены и периоды не заполнены.
          </div>
        </v-row>
        <v-divider></v-divider>
        @endif
        <object-attribute-price object-model="{{ $tour_object->model_alias }}"
          :price-type-options="{{ json_encode($price_type_options) }}" parent-id="{{ $item->id }}"
          parent-model="{{ $item->model_alias }}" :customers="{{ json_encode($customer_type_options) }}"
          token="{{ csrf_token() }}"></object-attribute-price>
        <v-card-actions>
          <v-btn text>Вернуться</v-btn>
          <v-spacer></v-spacer>
          <v-btn form="price-form" dark type="submit" color="#aa282a">
            Добавить
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</v-container>
@endsection