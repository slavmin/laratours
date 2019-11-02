<?php

namespace App\Listeners\Backend\Auth\User;


/**
 * Class UserEventListener.
 */
class UserEventListener
{
    /**
     * @param $event
     */
    public function onCreated($event)
    {
        \Log::info('User: '.$event->user->full_name.' ('.$event->user->email.') Created by '.auth()->user()->full_name);
    }

    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        \Log::info('User: '.$event->user->full_name.' ('.$event->user->email.') Updated by '.auth()->user()->full_name);
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        \Log::info('User: '.$event->user->full_name.' ('.$event->user->email.') Deleted by '.auth()->user()->full_name);
    }

    /**
     * @param $event
     */
    public function onConfirmed($event)
    {
        \Log::info('User: '.$event->user->full_name.' ('.$event->user->email.') Confirmed by '.auth()->user()->full_name);
    }

    /**
     * @param $event
     */
    public function onUnconfirmed($event)
    {
        \Log::info('User: '.$event->user->full_name.' ('.$event->user->email.') Unconfirmed by '.auth()->user()->full_name);
    }

    /**
     * @param $event
     */
    public function onPasswordChanged($event)
    {
        \Log::info('User: '.$event->user->full_name.' ('.$event->user->email.') Password Changed by '.auth()->user()->full_name);
    }

    /**
     * @param $event
     */
    public function onDeactivated($event)
    {
        \Log::info('User: '.$event->user->full_name.' ('.$event->user->email.') Deactivated by '.auth()->user()->full_name);
    }

    /**
     * @param $event
     */
    public function onReactivated($event)
    {
        \Log::info('User: '.$event->user->full_name.' ('.$event->user->email.') Reactivated by '.auth()->user()->full_name);
    }

    /**
     * @param $event
     */
    public function onSocialDeleted($event)
    {
        \Log::info('User Social Deleted');
    }

    /**
     * @param $event
     */
    public function onPermanentlyDeleted($event)
    {
        \Log::warning('User: '.$event->user->full_name.' ('.$event->user->email.') Permanently Deleted by '.auth()->user()->full_name);
    }

    /**
     * @param $event
     */
    public function onRestored($event)
    {
        \Log::info('User Restored');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Backend\Auth\User\UserCreated::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onCreated'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserUpdated::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onUpdated'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserDeleted::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onDeleted'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserConfirmed::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onConfirmed'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserUnconfirmed::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onUnconfirmed'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserPasswordChanged::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onPasswordChanged'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserDeactivated::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onDeactivated'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserReactivated::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onReactivated'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserSocialDeleted::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onSocialDeleted'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserPermanentlyDeleted::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onPermanentlyDeleted'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserRestored::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onRestored'
        );
    }
}
