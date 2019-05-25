<?php

namespace App\Models\Tour;

use App\Models\Traits\UsedByTeams;
use Illuminate\Database\Eloquent\Model;

class TourCustomer extends Model
{
    use UsedByTeams;

    public function setCustomerIdAttribute()
    {
        if ($this->wasRecentlyCreated === true) {
            $this->attributes['customer_id'] = auth()->user()->id ?? null;
        }
    }

    public function getCustomerIdAttribute()
    {
        //
    }

    public function setTeamIdAttribute()
    {
        $this->attributes['team_id'] = auth()->user()->currentTeam->getKey() ?? null;
    }

    public function getTeamIdAttribute()
    {
        //
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Tour\TourOrder')->withTimestamps();
    }
}
