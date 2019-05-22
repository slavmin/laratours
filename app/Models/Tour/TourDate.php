<?php

namespace App\Models\Tour;

use App\Models\Traits\UsedByTeams;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TourDate extends Model
{
    use UsedByTeams;

    protected $fillable = ['date'];


    public function setDateAttribute( $value )
    {
        $this->attributes['date'] = (new Carbon($value))->format('Y-m-d H:i:s');
    }

    public function getDateAttribute()
    {
        return (new Carbon($this->attributes['date']))->format('d.m.Y H:i');
    }

    public function tour()
    {
        return $this->belongsTo('App\Models\Tour\Tour')->withTimestamps();
    }
}
