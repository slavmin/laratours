<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mpociot\Teamwork\Traits\UsedByTeams;

class TourCountry extends Model
{
    use SoftDeletes, UsedByTeams;

    protected $fillable = ['name', 'description'];

    public function cities()
    {
        return $this->hasMany('App\Models\Tour\TourCity', 'country_id');
    }
}
