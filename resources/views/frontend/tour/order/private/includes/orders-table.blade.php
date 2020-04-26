<v-row class="justify-center">
    <v-col>
        <v-card>
            <table class="tc-order-table">
                <thead>
                    <th>
                        №
                    </th>
                    <th>
                        @lang('labels.frontend.tours.order.table.tour_name')
                    </th>
                    <th>
                        @lang('labels.frontend.tours.order.table.tourists_data')
                    </th>
                    <th>
                        @lang('labels.frontend.tours.order.table.price')
                    </th>
                    <th>
                        @lang('labels.frontend.tours.order.table.commission')
                    </th>
                    <th>
                        @lang('labels.frontend.tours.order.table.agency')
                    </th>
                    <th>
                        @lang('labels.frontend.tours.order.table.agency_status')
                    </th>
                    <th>
                        @lang('labels.frontend.tours.order.table.operator_status')
                    </th>
                    <th>
                        @lang('labels.general.actions')
                    </th>
                </thead>
                <tbody>
                    @foreach($tour->orders as $item)
                    <tr>
                        <td>
                            {{ $item->id }}
                        </td>
                        <td>
                            <span>{{$item->tour->name}}</span>
                        </td>
                        <td>
                            Туристов: {{ count($item->profiles[0]->content) }}
                        </td>
                        <td>
                            {{ $item->total_price }}
                        </td>
                        <td>
                            {{ $item->commission }}
                        </td>
                        <td>
                            @if($item->by_agent)
                            @if (array_key_exists($item->team_id, $agencies))
                            <span class="text-success mr-2"><i class="fas fa-user-check"></i></span>
                            <span class="text-secondary">{{ $agencies[$item->team_id] }}</span>
                            @endif
                            @else
                            @if($item->by_user)
                            <span class="text-info mr-2"><i class="fas fa-user"></i></span>
                            <span class="text-secondary">{{ $item->customer->full_name }}</span>
                            @else
                            <span class="text-muted mr-2"><i class="fas fa-user-slash"></i></span>
                            <span class="text-secondary">@lang('labels.frontend.tours.order.table.guest')</span>
                            @endif
                            @endif
                        </td>
                        <td>
                        </td>
                        <td>
                            @if (array_key_exists($item->status, $statuses))
                            <span
                                class="{{ $statuses[$item->status] }}">@lang('labels.frontend.tours.order.statuses.'.$item->status)</span>
                            @endif
                        </td>
                        <td>
                            <div class="float-right" role="toolbar"
                                aria-label="@lang('labels.general.toolbar_btn_groups')">
                                {!! $item->action_buttons !!}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </v-card>
    </v-col>
</v-row>