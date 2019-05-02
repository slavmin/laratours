<?php

namespace App\Models\Auth;

use App\Models\Auth\Traits\Attribute\TeamAttribute;
use App\Models\Auth\Traits\Method\TeamMethod;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mpociot\Teamwork\TeamworkTeam;
use Mpociot\Teamwork\TeamInvite;

/**
 * Class Team.
 */
class Team extends TeamworkTeam
{
    use TeamAttribute, TeamMethod, SoftDeletes;
}
