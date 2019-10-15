<?php

namespace App\Listeners\Frontend\Auth;

use App\Models\Auth\User;
use App\Notifications\Frontend\Auth\NotifyOnUserRegistered;
use Notification;

/**
 * Class UserEventListener.
 */
class UserEventListener
{
    /**
     * @param $event
     */
    public function onLoggedIn($event)
    {
        $ip_address = request()->getClientIp();

        // Update the logging in users time & IP
        $event->user->fill([
            'last_login_at' => now()->toDateTimeString(),
            'last_login_ip' => $ip_address,
        ]);

        // Update the timezone via IP address
        $geoip = geoip($ip_address);

        if ($event->user->timezone !== $geoip['timezone']) {
            // Update the users timezone
            $event->user->fill([
                'timezone' => $geoip['timezone'],
            ]);
        }

        $event->user->save();

        \Log::info('User Logged In: ' . $event->user->full_name);
    }

    /**
     * @param $event
     */
    public function onLoggedOut($event)
    {
        \Log::info('User Logged Out: ' . $event->user->full_name);
    }

    /**
     * @param $event
     */
    public function onRegistered($event)
    {
        $notification = new NotifyOnUserRegistered($event->user);
        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', '=', config('access.users.admin_role'));
        })->get();
        Notification::send($admins, $notification);

        \Log::info('User Registered: ' . $event->user->full_name);
    }


    /**
     * @param $event
     */
    public function onInvitedRegistered($event)
    {
        \Log::info('Invited User Registered: ' . $event->user->full_name);
    }

    /**
     * @param $event
     */
    public function onProviderRegistered($event)
    {
        \Log::info('User Provider Registered: ' . $event->user->full_name);
    }

    /**
     * @param $event
     */
    public function onConfirmed($event)
    {
        \Log::info('User Confirmed: ' . $event->user->full_name);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Frontend\Auth\UserLoggedIn::class,
            'App\Listeners\Frontend\Auth\UserEventListener@onLoggedIn'
        );

        $events->listen(
            \App\Events\Frontend\Auth\UserLoggedOut::class,
            'App\Listeners\Frontend\Auth\UserEventListener@onLoggedOut'
        );

        $events->listen(
            \App\Events\Frontend\Auth\UserRegistered::class,
            'App\Listeners\Frontend\Auth\UserEventListener@onRegistered'
        );

        $events->listen(
            \App\Events\Frontend\Auth\UserInvitedRegistered::class,
            'App\Listeners\Frontend\Auth\UserEventListener@onInvitedRegistered'
        );

        $events->listen(
            \App\Events\Frontend\Auth\UserProviderRegistered::class,
            'App\Listeners\Frontend\Auth\UserEventListener@onProviderRegistered'
        );

        $events->listen(
            \App\Events\Frontend\Auth\UserConfirmed::class,
            'App\Listeners\Frontend\Auth\UserEventListener@onConfirmed'
        );
    }
}
