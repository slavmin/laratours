<?php

namespace App\Listeners\Frontend\Order;

use App\Models\Auth\Team;
use App\Notifications\Frontend\Order\NotifyOnOrderCreated;
use App\Notifications\Frontend\Order\ReplyOnOrderCreated;
use Notification;


class OrderEventListener
{

    public function onCreated($event) {

        $notification = new NotifyOnOrderCreated($event->order);

        $team = Team::findOrFail($event->order->operator_id);

        // Send Notifications to team members
        $members = $team->users()->get();
        Notification::send($members, $notification);

        // Send reply to customer
        $customers = $event->order->profiles()->where('type', 'customer')->get()->pluck('content')->first();
        $customer = collect($customers)->first();
        Notification::route('mail', $customer['email'])->notify(new ReplyOnOrderCreated($event->order));

        \Log::info('Tour ID: ' . $event->order->tour_id . ' ordered from company: ' . $team->name);
    }

    public function onOrderStatusChanged($event) {

        \Log::info('Order ID: ' . $event->order->id . ' status changed from: ' . $event->order->getOriginal('status') . ' to: ' . $event->order->status);
    }

    public function onDeleted($event) {

        \Log::info('Order ID: ' . $event->order->id . ' for Tour ID '. $event->order->tour_id . ' was deleted');
    }

    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Frontend\Order\OrderCreated::class,
            'App\Listeners\Frontend\Order\OrderEventListener@onCreated'
        );

        $events->listen(
            \App\Events\Frontend\Order\OrderStatusChanged::class,
            'App\Listeners\Frontend\Order\OrderEventListener@onOrderStatusChanged'
        );

        $events->listen(
            \App\Events\Frontend\Order\OrderDeleted::class,
            'App\Listeners\Frontend\Order\OrderEventListener@onDeleted'
        );
    }
}
