<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\UsedByTeams;

class TourCity extends Model
{
    use SoftDeletes, UsedByTeams;

    protected $fillable = ['name', 'description'];

    public function country()
    {
        return $this->belongsTo('App\Models\Tour\TourCountry')->withDefault();
    }

    // Exposed relation
    public function museums()
    {
        return $this->hasMany('App\Models\Tour\TourMuseum', 'city_id');
    }

    // Exposed relation
    public function meals()
    {
        return $this->hasMany('App\Models\Tour\TourMeal', 'city_id');
    }

    // Exposed relation
    public function hotels()
    {
        return $this->hasMany('App\Models\Tour\TourHotel', 'city_id');
    }

    // Exposed relation
    public function transports()
    {
        return $this->hasMany('App\Models\Tour\TourTransport', 'city_id');
    }
}