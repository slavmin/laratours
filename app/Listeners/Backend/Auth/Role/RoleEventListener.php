<?php

namespace App\Listeners\Backend\Auth\Role;

/**
 * Class RoleEventListener.
 */
class RoleEventListener
{
    /**
     * @param $event
     */
    public function onCreated($event)
    {
        \Log::info('Role: '.$event->role->name.' Created by '.auth()->user()->full_name);
    }

    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        \Log::info('Role: '.$event->role->name.' Updated by '.auth()->user()->full_name);
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        \Log::info('Role: '.$event->role->name.' Deleted by '.auth()->user()->full_name);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Backend\Auth\Role\RoleCreated::class,
            'App\Listeners\Backend\Auth\Role\RoleEventListener@onCreated'
        );

        $events->listen(
            \App\Events\Backend\Auth\Role\RoleUpdated::class,
            'App\Listeners\Backend\Auth\Role\RoleEventListener@onUpdated'
        );

        $events->listen(
            \App\Events\Backend\Auth\Role\RoleDeleted::class,
            'App\Listeners\Backend\Auth\Role\RoleEventListener@onDeleted'
        );
    }
}
