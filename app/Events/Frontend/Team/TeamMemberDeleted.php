<?php

namespace App\Events\Frontend\Team;


use App\Models\Auth\User;
use Illuminate\Queue\SerializesModels;

class TeamMemberDeleted
{
    use SerializesModels;

    /**
     * @var
     */
    public $user;

    /**
     * @param $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}