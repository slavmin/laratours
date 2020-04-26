@extends('frontend.layouts.app')

@section('content')
@if(count($items)>0)
<v-container fluid grid-list-md text-xs-center>
    <h1 class="text-white text-center">
        @lang('labels.frontend.tours.order.management')
    </h1>
    <v-expansion-panels>
        @foreach ($orders_by_tours as $tour)
        <v-expansion-panel>
            <v-expansion-panel-header>
                <v-row>
                    <v-col cols="8">
                        <div class="headline">
                            «{{ $tour->name }}»
                        </div>
                        @if ($tour->deleted_at)
                        <span right class="text-xs-center subheading" style="color: red;">
                            Тур удалён
                        </span>
                        @endif
                        <div class="grey--text subheading">
                            @foreach($tour->cities_list as $city_id)
                            {{ $cities_names[$city_id] }}.
                            @endforeach
                        </div>
                    </v-col>
                    <v-col cols="4">
                        <span class="grey--text">
                            Дата отъезда:
                        </span>
                        <span class="subheading">
                            @foreach($tour->dates as $date)
                            {{ $date->date }}
                            @endforeach
                            {{ $tour->getOrderedQntAttribute() }}
                        </span>
                    </v-col>
                    <v-col cols="12">
                        <v-divider></v-divider>
                        Мест всего:
                        <span class="tc-tour-qnt tc-tour-qnt-total">
                            {{ $tour->qnt }}
                        </span>
                        Забронировано:
                        <span class="tc-tour-qnt tc-tour-qnt-ordered">
                            {{ $tour->getOrderedQntAttribute() }}
                        </span>
                        Свободных:
                        <span class="tc-tour-qnt tc-tour-qnt-free">
                            {{ $tour->qnt - $tour->getOrderedQntAttribute() }}
                        </span>
                    </v-col>
                </v-row>
            </v-expansion-panel-header>
            <v-expansion-panel-content>
                @include('frontend.tour.order.private.includes.orders-table')
            </v-expansion-panel-content>
        </v-expansion-panel>
        @endforeach
    </v-expansion-panels>
</v-container>

@endif

@endsection