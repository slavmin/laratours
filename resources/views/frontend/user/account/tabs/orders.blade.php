<div class="orders-wrap">
    @if($logged_in_user->orders->count())

        <div class="list-group list-group-flush mb-4">

            @foreach($logged_in_user->orders as $order)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <div class="w-25 p-2"><span class="text-secondary">{{ timezone()->convertToLocal($order->created_at, 'd.m.Y') }}</span></div>
                        <div class="flex-fill p-2">
                            @if (array_key_exists($order->tour_id, $tour_names))
                                <span class="text-secondary">{{$tour_names[$order->tour_id]}}</span>
                                @else
                                <span class="text-secondary">N/A</span>
                            @endif
                        </div>
                        <div class="flex-fill p-2">
                            @if (array_key_exists($order->status, $order_statuses))
                                <span class="text-secondary {{ $order_statuses[$order->status] }}">@lang('labels.frontend.tours.order.statuses.'.$order->status)</span>
                            @endif
                        </div>
                        <div class="w-25 text-right p-2"><span class="text-info">{{ $order->total_price }}</span></div>
                    </div>
                </div>
            @endforeach

        </div><!--/list-group-->

    @endif
</div>
