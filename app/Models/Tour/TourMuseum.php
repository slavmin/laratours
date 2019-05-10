<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UsedByTeams;
use App\Models\Tour\TourCity;

class TourMuseum extends Model
{
    use UsedByTeams;

    protected $fillable = ['name', 'city_id', 'description', 'price'];

    protected $casts = [
        'price' => 'float',
    ];

    /**
     * @return string
     */
    public function getCityAttribute()
    {
        $cities = TourCity::all()->pluck('name', 'id')->toArray();

        if (in_array($this->city_id, array_keys($cities))) {
            return ucwords($cities[$this->city_id]);
        }

        return 'N/A';
    }
}
