@extends('frontend.layouts.app')

@section('content')
{{-- @include('frontend.tour.includes.city-select-form') --}}
<v-container fluid grid-list-md text-xs-center>
    <h1 class="text-white text-center">
        @lang('labels.frontend.tours.'.$model_alias.'.management')
    </h1>
    <v-layout row wrap justify-center mb-5>
        <v-btn fab dark class="tc-red-bg tc-link-no-underline-on-hover" title="@lang('buttons.general.crud.create')"
            href="{{ route('frontend.tour.'.$model_alias.'.create', $city_param) }}">
            <i class="material-icons">
                add
            </i>
        </v-btn>
    </v-layout>
    <v-layout row wrap>
        @if(count($items)>0)
        @foreach($items as $item)
        <v-flex mb-5 xs12 md12 lg6 xl4>
            <v-card class="mx-auto" max-width="100%" outlined>
                <v-img height="200px"
                    src="{{ $item->getMedia('photos')->first() ? $item->getMedia('photos')->first()->getUrl() : '/img/frontend/'.$model_alias.'_tmpl.jpg' }}">
                    @if(!$item->getMedia('photos')->first())
                    <div class="fill-height repeating-gradient d-flex justify-center align-center">
                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                            <path fill="white"
                                d="M1.2,4.47L2.5,3.2L20,20.72L18.73,22L16.73,20H4A2,2 0 0,1 2,18V6C2,5.78 2.04,5.57 2.1,5.37L1.2,4.47M7,4L9,2H15L17,4H20A2,2 0 0,1 22,6V18C22,18.6 21.74,19.13 21.32,19.5L16.33,14.5C16.76,13.77 17,12.91 17,12A5,5 0 0,0 12,7C11.09,7 10.23,7.24 9.5,7.67L5.82,4H7M7,12A5,5 0 0,0 12,17C12.5,17 13.03,16.92 13.5,16.77L11.72,15C10.29,14.85 9.15,13.71 9,12.28L7.23,10.5C7.08,10.97 7,11.5 7,12M12,9A3,3 0 0,1 15,12C15,12.35 14.94,12.69 14.83,13L11,9.17C11.31,9.06 11.65,9 12,9Z" />
                        </svg>
                    </div>
                    @endif
                </v-img>
                <v-card-title></v-card-title>
                </v-img>
                <v-list-item three-line>
                    <v-list-item-content>
                        <div class="overline mb-4">тип/категория</div>
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
                        <div class="text-center mt-3">@lang('labels.frontend.tours.'.$model_alias.'.table.header')</div>
                        <v-simple-table class="objectables-table" dense>
                            <template v-slot:default>
                                <thead>
                                    <tr>
                                        <th class="text-left">@lang('labels.frontend.tours.'.$model_alias.'.table.name')
                                        </th>
                                        @if ($model_alias == "museum")
                                        <th class="text-center d-none d-md-table-cell">З/Н</th>
                                        <th class="text-center d-none d-md-table-cell">Доп</th>
                                        @endif
                                        <th class="text-left">
                                            @lang('labels.frontend.tours.'.$model_alias.'.table.price')</th>
                                        <th class="text-right">@lang('labels.general.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($item->objectables as $object_attribute)
                                    <tr>
                                        <td>{{ $object_attribute->name }}</td>
                                        @if ($model_alias == "museum")
                                        <td class="text-center d-none d-md-table-cell">
                                            @if(isset(json_decode($object_attribute->extra)->isCustomOrder))
                                            <v-icon>
                                                check
                                            </v-icon>
                                            @endif
                                        </td>
                                        <td class="text-center d-none d-md-table-cell">
                                            @if(isset(json_decode($object_attribute->extra)->isExtra) &&
                                            json_decode($object_attribute->extra)->isExtra)
                                            <v-icon>
                                                check
                                            </v-icon>
                                            @endif
                                        </td>
                                        @endif
                                        <td>
                                            <?php 
                                                $prices_array = $object_attribute->priceable;
                                                if (count($prices_array) > 0) {
                                                    $min_price = $prices_array[0]->price; 
                                                    foreach($prices_array as $price) {
                                                        if ($min_price > $price->price) {
                                                            $min_price = $price->price;
                                                        }
                                                    }
                                                    $result = 'от ' . $min_price;
                                                } else {
                                                    $result = 'цены не найдены';
                                                }
                                            ?>
                                            {{ $result }}
                                        </td>
                                        <td>
                                            <v-row>
                                                <v-spacer></v-spacer>
                                                <v-btn icon small color="yellow"
                                                    href="{{ route('frontend.tour.attribute.edit', $object_attribute->id) }}"
                                                    title="{{ 'Редактировать "'. $object_attribute->name .'"' }}">
                                                    <v-icon>edit</v-icon>
                                                </v-btn>
                                                {{ html()
                              ->form('DELETE', route('frontend.tour.attribute.destroy', $object_attribute->id))
                              ->open() }}
                                                <v-btn icon small color="red" type="submit"
                                                    title="{{ 'Удалить "'. $object_attribute->name .'"' }}">
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
                    <v-btn fab small dark class="tc-red-bg tc-link-no-underline-on-hover"
                        title="@lang('buttons.general.crud.create')"
                        href="{{ route('frontend.tour.attribute.create', ['parent_model_id' => $item->id, 'parent_model_alias' => $item->model_alias]) }}">
                        <i class="material-icons">
                            add
                        </i>
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-flex>
        @endforeach
        @endif
    </v-layout>
</v-container>

@include('frontend.tour.includes.pagination-row')

@include('frontend.tour.includes.trash-bin')

@endsection