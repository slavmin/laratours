@extends('frontend.layouts.app')

@section('content')
  <v-container
    fluid
    grid-list-md
    text-xs-center
  >
    <h1 class="text-white text-center">
      {{$item->name}}
    </h1>
    <v-row justify="center">
      <v-col xs="12" lg="8">
        <v-card>
          <v-card-title>
            Цены:
          </v-card-title>
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
                  Тип туриста
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
                        {{ $customer_type_options[$price->tour_customer_type_id] }}
                      </td>
                      <td>
                        {{ $price->price }}
                      </td>
                      <td>
                        {{ html()
                          ->form('DELETE', route('frontend.tour.attribute-price.destroy', $price->id))
                          ->open() }}
                          <v-btn 
                            icon 
                            small 
                            color="red" 
                            type="submit"
                            title="Удалить"
                          >
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
          <v-divider></v-divider>
          <object-attribute-price
            parent-id="{{ $item->id }}"
            :customers="{{ json_encode($customer_type_options) }}"
            token="{{ csrf_token() }}"
          ></object-attribute-price>
          <v-card-actions>
            <v-btn text>Вернуться</v-btn>
            <v-spacer></v-spacer>
            <v-btn
              form="price-form"
              dark
              type="submit"
              color="#aa282a"
            >
              Добавить
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
    {{-- {{dd($item->objectable->getModelAliasAttribute())}} --}}
  </v-container>
@endsection