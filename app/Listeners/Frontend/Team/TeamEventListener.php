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
        \Log::info('Team : ' . $event->user->full_name . ' user attached to team ' . $team->name);
    }

    /**
     * @param $event
     */
    public function onMemberDetached($event)
    {
        $team = Team::findOrFail($event->user->current_team_id);
        \Log::warning('Team : ' . $event->user->full_name . ' user detached from team ' . $team->name);
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
            \App\Events\Frontend\Team\TeamMemberDeleted::class,
            'App\Listeners\Frontend\Team\TeamEventListener@onMemberDetached'
        );
    }
}