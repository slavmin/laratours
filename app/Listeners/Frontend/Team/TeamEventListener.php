<?php


namespace App\Listeners\Frontend\Team;

use App\Models\Auth\Team;

class TeamEventListener
{
    /**
     * @param $event
     */
    public function onMemberAttached($event)
    {
        $team = Team::findOrFail($event->user->current_team_id);
        \Log::info('Team : User ' . $event->user->full_name . ' attached to ' . $team->name);
    }

    /**
     * @param $event
     */
    public function onMemberDetached($event)
    {
        $team = Team::findOrFail($event->user->current_team_id);
        \Log::warning('Team : User ' . $event->user->full_name . ' detached from ' . $team->name);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Frontend\Team\TeamMemberAdded::class,
            'App\Listeners\Frontend\Team\TeamEventListener@onMemberAttached'
        );

        $events->listen(
            \App\Events\Frontend\Team\TeamDeleted::class,
            'App\Listeners\Frontend\Team\TeamEventListener@onMemberDetached'
        );
    }
}