<?php

namespace App\Models\Tour;

use App\Models\Tour\Traits\Attribute\ActionButtonsAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\UsedByTeams;
use App\Models\Traits\HasPagination;

class TourCity extends Model
{
    use SoftDeletes, UsedByTeams, HasPagination, ActionButtonsAttribute;

    protected $fillable = ['name', 'description'];

    protected $supportedRelations = ['museums', 'meals', 'hotels', 'transports'];

    protected $appends = ['model_alias'];


    public static function getModelAliasAttribute()
    {
        return 'city';
    }

    public function scopeWithAll($query)
    {
        return $query->with($this->supportedRelations);
    }



    public function country()
    {
        return $this->belongsTo('App\Models\Tour\TourCountry')->withDefault();
    }

    // Exposed relation
    public function museums()
    {
        return $this->hasMany('App\Models\Tour\TourMuseum', 'city_id')->withDefault([]);
    }

    // Exposed relation
    public function meals()
    {
        return $this->hasMany('App\Models\Tour\TourMeal', 'city_id')->withDefault([]);
    }

    // Exposed relation
    public function hotels()
    {
        return $this->hasMany('App\Models\Tour\TourHotel', 'city_id')->withDefault([]);
    }

    // Exposed relation
    public function transports()
    {
        return $this->hasMany('App\Models\Tour\TourTransport', 'city_id')->withDefault([]);
    }
}