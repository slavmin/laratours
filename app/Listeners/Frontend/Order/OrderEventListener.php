<?php

namespace App\Listeners\Frontend\Order;

use App\Models\Auth\Team;
use App\Notifications\Frontend\Order\NotifyOnOrderCreated;
use App\Notifications\Frontend\Order\ReplyOnOrderCreated;
use Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderEventListener
{

    public function onCreated($event) {

        $notification = new NotifyOnOrderCreated($event->order);

        $team = Team::findOrFail($event->order->operator_id);

        $members = $team->users()->get();

        Notification::send($members, $notification);

        // Send reply to customer
        $customers = $event->order->profiles()->where('type', 'customer')->get()->pluck('content')->first();

        Notification::route('mail', $customers[0]['email'])->notify(new ReplyOnOrderCreated($event->order));

        \Log::info('Tour ordered: ' . $event->order->id);
    }

    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Frontend\Order\OrderCreated::class,
            'App\Listeners\Frontend\Order\OrderEventListener@onCreated'
        );
    }
}
