<?php


namespace App\Listeners\Backend\Auth\Team;

use App\Models\Auth\Team;

class TeamEventListener
{

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        \Log::warning('Team: '.$event->team->name.' Permanently Deleted');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Backend\Auth\Team\TeamDeleted::class,
            'App\Listeners\Backend\Auth\Team\TeamEventListener@onDeleted'
        );
    }
}