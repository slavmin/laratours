<?php

namespace App\Events\Backend\Auth\Team;


use App\Models\Auth\Team;
use Illuminate\Queue\SerializesModels;

class TeamDeleted
{
    use SerializesModels;

    /**
     * @var
     */
    public $team;

    /**
     * @param $team
     */
    public function __construct(Team $team)
    {
        $this->team = $team;
    }
}