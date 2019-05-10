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
}